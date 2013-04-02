<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\BlockInterface;
use Rhoban\Blocks\EnvironmentInterface;

abstract class Block implements BlockInterface
{
    /**
     * The meta information array of the block
     */
    private static $META;

    /**
     * The parameter values of the block
     */
    private $parameterValues = array();

    /**
     * Compiler Environment (Rhoban\Blocks\EnvironmentInterface)
     */
    private $environment;

    /**
     * The block id
     */
    private $id;

    /**
     * Initialize the block fron json representation
     * @param $data : json array representation from blocks.js
     */
    public function __construct(array $data, EnvironmentInterface $environment)
    {
        $this->environment = $environment;
        $this->id = $data['id'];
        $this->parameterValues = $data['parameters'];
        $this->checkParameters();
    }

    /**
     * @inherit
     */
    public static function generateJSON()
    {
        return json_encode(static::$META);
    }

    /**
     * @inherit
     */
    public function generateInitCode()
    {
        return $this->implementInitCode();
    }
    public function generateTransitionCode(array $linksReversed)
    {
        //Build inputs and parameters container
        //Resolves identifiers and type from incomming blocks
        //for code generation
        $parametersContainer = array();
        $inputsContainer = array();

        //Inputs
        $meta = $this->getMeta();
        foreach ($meta['inputs'] as $index => $input) {
            $name = $input['name'];
            $intputsContainer[$name] = array();
            foreach ($linksReversed['input_'.$index] as $link) {
                $srcId = $link['blockId'];
                $srcIndex = substr($link['index'], 7);
                $inputsContainer[$name][] = array(
                    'identifier' => $this->environment
                        ->stateName($srcId, $srcIndex),
                    'type' => $this->environment
                        ->stateType($srcId, $srcIndex),
                );
            }
        }
        //Parameters
        foreach ($meta['parameters'] as $index => $param) {
            $name = $param['name'];
            $parametersContainer[$name] = array();
            foreach ($linksReversed['param_'.$index] as $link) {
                $srcId = $link['blockId'];
                $srcIndex = substr($link['index'], 7);
                $parametersContainer[$name][] = array(
                    'identifier' => $this->environment
                        ->stateName($srcId, $srcIndex),
                    'type' => $this->environment
                        ->stateType($srcId, $srcIndex),
                );
            }
            //if parameters value is not given from an other block
            //block parameter value is used and its type is guess
            if (count($parametersContainer[$name]) == 0) {
                $value = $this->parameterValues[$name];
                $parametersContainer[$name][] = array(
                    'identifier' => $value,
                    'type' => $this->environment
                        ->guestVariableType($value),
                );
            }
        }

        //Call code implementation
        $code = $this->implementTransitionCode(
            $parametersContainer, 
            $inputsContainer, 
            $this->environment);

        //Check that all block output states have been register
        //by the implementation
        foreach ($meta['outputs'] as $index => $output) {
            try {
                $this->environment->stateName($this->getId(), $index);
            } catch (\InvalidArgumentException $e) {
                throw new \LogicException(
                    'State not registered for block '.$this->getId());
            }
        }

        return $code;
    }

    /**
     * Implementation of generateInitCode and
     * generateTransitionCode
     * The methods is overide by block implementations
     *
     * @return string code
     */
    protected function implementInitCode()
    {
        return '';
    }
    abstract protected function implementTransitionCode(
        array $parameters, 
        array $inputs, 
        EnvironmentInterface $environment);

    /**
     * @inherit
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inherit
     */
    public function getMeta()
    {
        return static::$META;
    }
    
    public function getMinCardInput($index)
    {
        return $this->getCard('inputs', $index, true);
    }
    public function getMaxCardInput($index)
    {
        return $this->getCard('inputs', $index, false);
    }
    public function getMinCardOutput($index)
    {
        return $this->getCard('outputs', $index, true);
    }
    public function getMaxCardOutput($index)
    {
        return $this->getCard('outputs', $index, false);
    }
    public function getMinCardParam($index)
    {
        return 0;
    }
    public function getMaxCardParam($index)
    {
        return 1;
    }

    /**
     * Check parsed parameters against meta
     * informations
     * Throw Exception if error
     */
    private function checkParameters()
    {
        $meta = $this->getMeta();
        foreach ($meta['parameters'] as $param) {
            if (!array_key_exists($param['name'], $this->parameterValues)) {
                throw new \RuntimeException(
                    'Missing block parameters '.$param['name']);
            }
        }
    }

    /**
     * Return min and max cardinality
     * @param $name : string (input|output|parameters)
     * @param $index : integer
     * @param $isMin : bool return min card of true, else max
     *
     * @return null or integer
     */
    private function getCard($name, $index, $isMin)
    {
        $meta = $this->getMeta();
        if ($index >= count($meta[$name])) {
            throw new \InvalidArgumentException(
                'Invalid '.$name.' cardinality index '.$index);
        }
        if (
            !is_array($meta[$name][$index]) || 
            !array_key_exists('card', $meta[$name][$index])
        ) {
            throw new \LogicException('Invalid META cardinality');
        }
        $card = $meta[$name][$index]['card'];

        if ($isMin) {
            if ($card{0} == '*') return null;
            else return $card{0};
        } else {
            if (strlen($card) != 3) return $card{0};
            else if ($card{2} == '*') return null;
            else return $card{2};
        }
    }
}
