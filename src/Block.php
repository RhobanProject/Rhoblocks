<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\BlockInterface;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Edge;

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
     * Array of Rhoban\Blocks\Edge
     */
    protected $edges = array();

    /**
     * Cache to keep the variable names etc.
     */
    protected $cache = array();

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
     * Adding an edge that enter in this block
     * @param $edge Rhoban\Blocks\Edge
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
        return $this->implementTransitionCode();
    }

    /**
     * Adds the type information to an entry
     */
    public function addType(array $entry)
    {
        if (isset($entry['type'])) {
            $entry['variableType'] = VariableType::stringToType($entry['type']);
        } else {
            $entry['variableType'] = VariableType::Unknown;
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
                if (isset($meta[$section][$name[0]])) {
                    $entry = $meta[$section][$name[0]];
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
     * Gets the output identifier for given index
     */
    public function getGlobalOutputIdentifier($index, $type)
    {
        $name = 'global_output_'.$index;

        if (!isset($this->cache[$name])) {
            $this->cache[$name] = $this->environment->registerOutput($index, $type);
        }

        return $this->cache[$name];
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
     * Gets the weakest type of all the inputs of this block
     */
    public function getWeakestType()
    {
        $type = VariableType::getWeakest();

        // Watching the inputing edges
        foreach ($this->edges as $ioName => $edges) {
            foreach ($edges as $edge) {
                if ($edge->isEnteringIn($this)) {
                    $section = $edge->ioSection($this);
                    $entry = $this->getEntry($section[0].'s', $section[1], true);
                    $this->addType($entry);

                    $currentType = $entry['variableType'];

                    if ($currentType == VariableType::Unknown) {
                        $currentType = $edge->inputIdentifier()->getType();
                    }

                    if (VariableType::isNumeric($currentType)) {
                        $type = max($type, $currentType);
                    }
                }
            }
        }

        // Watching the parameters
        $meta = $this->getMeta();
        foreach ($meta['parameters'] as $parameter) {
            $parameter = $this->getParameterIdentifier($parameter['name']);
            $type = max($parameter->getType(), $type);
        }

        return $type;
    }

    /**
     * Gets the identifier for the given output
     *
     * @param $name, the name of the input
     * @param $id, is it the identifier or the name
     */
    public function getOutputIdentifier($nameOrId, $id = false)
    {
        if (!$id) {
            if (is_array($nameOrId)) {
                list($name, $index) = $nameOrId;
            } else {
                $name = $nameOrId;
                $index = null;
            }

            $entry = $this->getEntry('outputs', $name);
            $ioName = 'output_' . $entry['id'];

            if ($index !== null) {
                $ioName .= '_' . $index;
            }
        } else {
            $ioName = 'output_' . implode('_', $nameOrId);
            $entry = $this->getEntry('outputs', $nameOrId, true);
        }

        $type = $entry['variableType'];
        if ($type == VariableType::Unknown) {
            $type = $this->getWeakestType();
        }

        return $this->getVariableIdentifier($ioName, $type);
    }

    /**
     * Gets the size of a variadic section
     */
    public function getVariadicSize($section, $name)
    {
        $entry = $this->getEntry('inputs', $name);

        if (!isset($entry['length'])) {
            throw new \RuntimeException('The field '.$name.' is not variadic and does not have size');
        } else {
            $length = $entry['length'];
            if (is_numeric($length)) {
                return (int)$length;
            }

            $parts = explode('.', $length);
            if (count($parts) == 2) {
                $key = $parts[0];
                $operation = $parts[1];

                if ($operation == 'length') {
                    throw new \RuntimeException('Variadicity "Something.length" is unimplemented');
                }

                if ($operation == 'value') {
                    return (int)$this->parameterValues[$key];
                }
            }

            throw new \RuntimeException($length.' is not a valid variadic length');
        }
    }

    /**
     * Get the size of a variadic input
     */
    public function getInputSize($name)
    {
        return $this->getVariadicSize('inputs', $name);
    }

    /**
     * Get the size of a variadic output
     */
    public function getOutputSize($name)
    {
        return $this->getVariadicSize('outputs', $name);
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
        $index = null;
        if (is_array($name)) {
            list($name, $index) = $name;
        }

        $entry = $this->getEntry($section, $name);
        $ioName = $prefix . '_' . $entry['id'];

        if ($index !== null) {
            $ioName .= '_' . $index;
        }
        
        $card = $this->getCardinality($ioName);

        if ($card) {
            if ($multiple && $card > 1) {
                throw new \RuntimeException('Querying single input identifier for "'.$name.'", but there is multiple edges arriving in it');
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
                list($value, $type) = Identifier::guessType($default, $entry['variableType']);
                return new Identifier($this->environment, $value, $type);
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
                throw new \RuntimeException
                    ('Misformed cardilanity, min must be lower than max "'.$cardString.'"');
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
            $name = $param['name'];

            if (isset($param['type']) && $param['type'] == 'check') {
                $this->parameterValues[$name] = (isset($this->parameterValues[$name]) && $this->parameterValues[$name] == 'on') ? 1 : 0;
            }

            if (!array_key_exists($name, $this->parameterValues)) {
                throw new \RuntimeException(
                    'Missing block parameters '.$param['name']);
            } else {
                $this->parameterValues[$name] = str_replace(',', '.', $this->parameterValues[$name]);
            }
        }
    }
}
