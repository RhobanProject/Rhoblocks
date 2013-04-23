<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\Exceptions\ParametersException;
use Rhoban\Blocks\BlockInterface;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Edge;

abstract class Block implements BlockInterface
{
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
     * Initialize the block fron json representation
     * @param $data : json array representation from blocks.js
     */
    public function __construct(array $data, EnvironmentInterface $environment)
    {
        $this->environment = $environment;
        $this->id = $data['id'];
        $this->parameterValues = $data['parameters'];
        $this->checkParameters();
        static::checkMeta();
    }

    /**
     * Should this block be ignored in loop testing ?
     */
    public function isLoopable()
    {
        $meta = $this->getMeta();

        return (isset($meta['loopable']) && $meta['loopable']);
    }

    /**
     * Returns the name of the block
     */
    public function getName()
    {
        $meta = $this->getMeta();
        return $meta['name'];
    }

    /**
     * Return the block identifier (name and id)
     */
    public function getBlockId()
    {
        return $this->getName().'#'.$this->getId();
    }

    /**
     * Returns the block metas
     */
    public function getMeta()
    {
        return static::meta();
    }

    /**
     *
     */
    public static function checkMeta()
    {
        $fields = array('family', 'description');
        $sections = array('parameters', 'inputs', 'outputs');
        $meta = static::meta();

        if (!isset($meta['name'])) {
            throw new \RuntimeException('Meta: A block does not have name');
        }
        $name = $meta['name'];

        foreach ($fields as $field) {
            if (!isset($meta[$field])) {
                throw new \RuntimeException('Meta: There is no field "'.$field.'" in the block "'.$name.'"');
            }
        }

        foreach ($sections as $section) {
            if (!isset($meta[$section])) {
                throw new \RuntimeException('Meta: There is no section "'.$section.'" in the block "'.$name.'"');
            }

            if (!is_array($meta[$section])) {
                throw new \RuntimeException('Meta: Section "'.$section.'" is not an array in the block "'.$name.'"');
            }

            foreach ($meta[$section] as $entry) {
                if (!is_array($entry)) {
                    throw new \RuntimeException('Meta: Section "'.$section.'" contains malformed entries in block "'.$name.'"');
                }
            }
        }
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
        return json_encode(static::meta());
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
     * Gets the output identifier for given index
     */
    public function getGlobalOutputIdentifier($index, $type)
    {
        return $this->environment->registerGlobal('output', $index, $type);
    }

    /**
     * Register a variable
     */
    public function getVariableIdentifier($name, $type, $global = false, $dimension = 0)
    {
        if ($global) {
            return $this->environment->registerState($this->getId(), $name, $type, $dimension);
        } else {
            return $this->environment->registerVariable($this->getId(), $name, $type, $dimension);
        }
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
                if ($edge->isEnteringIn($this) && !$edge->isLoopable()) {
                    $section = $edge->ioSection($this);
                    $entry = $this->getEntry($section[0].'s', $section[1][0], true);
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
            if (isset($parameter['type']) && is_array($parameter['type'])) {
                foreach ($parameter['type'] as $subType) {
                    $size = $this->getParameterVariadicSize($parameter['name'], $subType['name']);

                    for ($i=0; $i<$size; $i++) {
                        $parameterId = $this->getParameterVariadicIdentifier($parameter['name'], $subType['name'], $i);
                        
                        if (VariableType::isNumeric($parameterId->getType())) {
                           $type = max($parameterId->getType(), $type);
                        }
                    }
                }
            } else {
                $parameterId = $this->getParameterIdentifier($parameter['name']);

                if (VariableType::isNumeric($parameterId->getType())) {
                    $type = max($parameterId->getType(), $type);
                }
            }
        }

        return $type;
    }

    /**
     * Guess the type of an output
     */
    protected function guessOutputType($name)
    {
        return $this->getWeakestType();
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
            $entry = $this->getEntry('outputs', $nameOrId[0], true);
        }

        $type = $entry['variableType'];
        if ($type == VariableType::Unknown) {
            $type = $this->guessOutputType($entry['name']);
        }

        return $this->getVariableIdentifier($ioName, $type);
    }

    /**
     * Gets the size of a variadic section
     */
    public function getVariadicSize($section, $name)
    {
        $entry = $this->getEntry($section, $name);

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
                    $max = 0;

                    foreach ($this->parameterValues[$key] as $array) {
                        $max = max($max, count($array));
                    }

                    return $max;
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

        if ($card || $multiple) {
            if (!$multiple && $card > 1) {
                throw new \RuntimeException('Querying single input identifier for "'.$name.'", but there is multiple edges arriving in it');
            }

            $identifiers = array();
            if (isset($this->edges[$ioName])) {
                foreach ($this->edges[$ioName] as $edge) {
                    $identifiers[] = $edge->inputIdentifier();
                }
            }

            if ($multiple) {
                return $identifiers;
            } else {
                return $identifiers[0];
            }
        } else {
            if ($default === null && isset($entry['default'])) {
                $default = $entry['default'];
            }

            if ($default !== null) {
                return $this->valueToIdentifier($entry, $default);
            } else {
                throw new \RuntimeException('Cannot access identifier for input "'.$name.'" because it\'s not linked and has no default value');
            }
        }
    }

    public function valueToIdentifier($entry, $value)
    {
        list($value, $type) = Identifier::guessType($value, $entry['variableType']);
        return new Identifier($this->environment, $value, $type);
    }
    
    public function getInputIdentifier($name)
    {
        return $this->getIdentifier('inputs', 'input', $name, false);
    }

    /**
     * Gets the cardinality, i.e the number of arriving edges in an input
     *
     * @param $name the input
     *
     * @return the number of arriving edges on the input given by $name
     */
    public function getInputCardinality($name)
    {
        $entry = $this->getEntry('inputs', $name);
        $ioName = 'input_' . $entry['id'];

        return $this->getCardinality($ioName);
    }
    
    public function getInputIdentifiers($name)
    {
        return $this->getIdentifier('inputs', 'input', $name, true);
    }
    
    public function getParameterVariadicSize($key, $name)
    {
        if (!isset($this->parameterValues[$key][$name])) {
            throw new \RuntimeException('The variadic parameter "'.$name.'.'.$key.'" does not exists');
        }
 
        return count($this->parameterValues[$key][$name]);
    }

    public function getParameterVariadicIdentifier($key, $name, $index)
    {
        $meta = $this->getEntry('parameters', $key);

        if (!isset($this->parameterValues[$key][$name])) {
            throw new \RuntimeException('The variadic parameter "'.$name.'.'.$key.'" does not exists');
        }

        $entry = null;
        foreach ($meta['type'] as $tempEntry) {
            if ($tempEntry['name'] == $name) {
                $entry = $tempEntry;
                $entry = $this->addType($entry);
                break;
            }
        }

        if (!$entry) {
            throw new \RuntimeException('The variadic parameter entry for "'.$key.'.'.$name.'"');
        }
 
        if (!isset($this->parameterValues[$key][$name][$index])) {
            throw new \RuntimeException('The variadic parameter "'.$name.'.'.$key.'['.$index.']" does not exists');
        }
        return $this->valueToIdentifier($entry, $this->parameterValues[$key][$name][$index]);
    }
    
    public function getParameterIdentifier($name)
    {
        if (!isset($this->parameterValues[$name])) {
            throw new \RuntimeException('The parameter "'.$name.'" does not exists');
        }

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
            throw new \RuntimeException('Bad cardinality for "'.$ioName.'" in block '.$this->getBlockId());
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

            if (isset($param['type']) && is_array($param['type'])) {
                $this->parameterValues[$name] = array();
                $prefix = $name;

                foreach ($param['type'] as $subType) {
                    $subName = $name.'.'.$subType['name'];

                    if (!isset($this->parameterValues[$subName]) || $this->parameterValues[$subName] === '') {
                        throw new ParametersException('Missing block variadic sub-parameter '.$param['name']);
                    } else {
                        $this->parameterValues[$name][$subType['name']] = $this->parameterValues[$subName];
                    }
                }
            } else {
                if (!isset($this->parameterValues[$name]) || $this->parameterValues[$name] === '') {
                    throw new ParametersException('Missing block parameters '.$param['name']);
                } else {
                    $this->parameterValues[$name] = $this->parameterValues[$name];
                }
            }
        }
    }
}
