<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\BlockInterface;
use Rhoban\Blocks\EnvironmentInterface;

abstract class Block implements BlockInterface
{
    /**
     * The meta information array of the block
     */
    protected static $META;

    /**
     * The parameter values of the block
     */
    protected $parameterValues = array();

    /**
     * Compiler Environment (Rhoban\Blocks\EnvironmentInterface)
     */
    protected $environment;

    /**
     * The block id
     */
    protected $id;

    /**
     * Edges concerning this block
     */
    protected $edges = array();

    /**
     * Cache to keep the variable names etc.
     */
    protected $cache = array();

    /**
     * Adding an edge that enter in this block
     */
    public function addEdge(Edge $edge)
    {
        $key = $edge->ioName($this);

        if (!isset($this->edges[$key])) {
            $this->edges[$key] = array();
        }

        $this->edges[$key][] = $edge;
    }

    /**
     * Gets the cardinality for an I/O name
     */
    public function getCardinality($ioName)
    {
        if (!isset($this->edges[$ioName])) {
            return 0;
        }

        return count($this->edges[$ioName]);
    }

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

    public function generateTransitionCode()
    {
        // Call code implementation
        return $this->implementTransitionCode();
    }

    /**
     * Adds the type information to an entry
     */
    public function addType(array $entry)
    {
        if (isset($entry['type']) && $entry['type'] == 'integer') {
            $entry['variableType'] = VariableType::Integer;
        } else {
            $entry['variableType'] = VariableType::Scalar;
        }

        return $entry;
    }

    /**
     * Gets an entry by name or id
     *
     * @param $section the section of the meta
     * @param $name the name or the id of the meta
     * @param $id true for the id, false for the name
     *
     * @return the entry or null if it's not found
     */
    public function getEntry($section, $name, $id = false)
    {
        $meta = $this->getMeta();

        if (isset($meta[$section])) {
            if ($id) {
                if (isset($meta[$section][$name])) {
                    $entry = $meta[$section][$name];
                    $entry['id'] = $id;
                    return $this->addType($entry);
                }
            } else {
                foreach ($meta[$section] as $id => $entry) {
                    if (isset($entry['name']) && $entry['name'] == $name) {
                        $entry['id'] = $id;
                        
                        return $this->addType($entry);
                    }
                }
            }
        }

        throw new \RuntimeException('No entry "'.$name.'" in section "'.$section.'"');
    }

    /**
     * Register a state or get its identifier from the cache
     */
    public function getVariableIdentifier($name, $type, $global = false)
    {
        if (!isset($this->cache[$name])) {
            if ($global) {
                $this->cache[$name] = $this->environment->registerVariable($this->getId(), $name, $type);
            } else {
                $this->cache[$name] = $this->environment->registerState($this->getId(), $name, $type);
            }
        }

        return $this->cache[$name];
    }
 
    /**
     * Gets the identifier for the given output
     */
    public function getOutputIdentifier($name, $id = false)
    {
        if (!$id) {
            $entry = $this->getEntry('outputs', $name);
            $ioName = 'output_' . $entry['id'];
        } else {
            $ioName = 'output_' . $id;
            $entry = $this->getEntry('outputs', $name, true);
        }

        return $this->getVariableIdentifier($ioName, $entry['variableType']);
    }

    /**
     * Gets the output as an L value
     */
    public function getOutputLIdentifier($name)
    {
        return $this->getOutputIdentifier($name)->lValue();
    }
    
    public function getIdentifier($section, $prefix, $name, $multiple = false, $default = null)
    {
        $entry = $this->getEntry($section, $name);
        $ioName = $prefix . '_' . $entry['id'];
        $card = $this->getCardinality($ioName);

        if ($card) {
            if ($multiple && $card > 1) {
                throw new \RuntimeException('Querying single input idnetifier for "'.$name.'", but there is multiple edges arriving in it');
            }

            $identifiers = array();
            foreach ($this->edges[$ioName] as $edge) {
                $identifiers[] = $edge->inputIdentifier();
            }

            if ($multiple) {
                return $identifiers;
            } else {
                return $identifiers[0];
            }
        } else {
            if ($default !== null) {
                return new Identifier($this->environment, $default, $entry['variableType']);
            } else {
                throw new \RuntimeException('Cannot access identifier for input "'.$name.'" because it\'s not linked');
            }
        }
    }
    
    public function getInputIdentifier($name)
    {
        return $this->getIdentifier('inputs', 'input', $name, false);
    }
    
    public function getInputIdentifiers($name)
    {
        return $this->getIdentifier('inputs', 'input', $name, true);
    }
    
    public function getParameterIdentifier($name)
    {
        return $this->getIdentifier('parameters', 'param', $name, false, $this->parameterValues[$name]);
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
    protected function implementTransitionCode()
    {
        return '';
    }

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
    
    /**
     * Parses the cardinality
     *
     * @param the cardinality, for example 2 or 0-*
     *
     * @return the array(a, b) where a is the min and b the max
     */
    public static function parseCard($cardString)
    {
        $card = explode('-', $cardString);

        if (count($card) == 1) {
            $card = array($cardString, $cardString);
        }

        if (count($card) > 2) {
            throw new \RuntimeException('Misformed cardilanity "'.$cardString.'"');
        }

        $card[0] = (int)$card[0];
        if ($card[1] != '*') {
            $card[1] = (int)$card[1];

            if ($card[0] > $card[1]) {
                throw new \RuntimeException('Misformed cardilanity, min must be lower than max "'.$cardString.'"');
            }
        }

        return $card;
    }

    /**
     * Checks that the $card cardinality is good for $ioName
     */
    public function checkCardinality(array $card, $ioName)
    {
        $n = $this->getCardinality($ioName);

        if ($n < $card[0] || ($card[1] != '*' && $n > $card[1])) {
            throw new \RuntimeException('Bad cardinality for "'.$ioName.'" in block '.$this->getId);
        }
    }

    /**
     * Check the cardinalities of the edges
     */
    public function checkCardinalities()
    {
        $metaToIo = array(
            'inputs' => 'input',
            'outputs' => 'output',
            'parameters' => 'param'
        );

        $meta = $this->getMeta();
        foreach ($metaToIo as $metaKey => $io) {
            foreach ($meta[$metaKey] as $index => $point) {
                if (isset($point['card'])) {
                    $card = static::parseCard($point['card']);
                } else {
                    $card = array(0, 1);
                }

                $ioName = $io.'_'.$index;

                $this->checkCardinality($card, $ioName);
            }
        }
    }

    /**
     * Check parsed parameters against meta informations
     * Throw Exception if error
     */
    protected function checkParameters()
    {
        $meta = $this->getMeta();

        foreach ($meta['parameters'] as $param) {
            if (!array_key_exists($param['name'], $this->parameterValues)) {
                throw new \RuntimeException(
                    'Missing block parameters '.$param['name']);
            }
        }
    }
}
