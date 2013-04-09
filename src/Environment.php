<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;
use Rhoban\Blocks\Identifier;

/**
 * Environment
 */
abstract class Environment implements EnvironmentInterface
{
    /**
     * Global and stack variable containers
     */
    protected $global = array();
    protected $stack = array();

    /**
     * The options specific to the compilation
     */
    public function getDefaultOptions()
    {
        return array(
            'frequency' => 50,
            'prefix' => 'blocks'
        );
    }

    /**
     * Options
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->options = array_merge($this->getDefaultOptions(), $options);
    }

    /**
     * Shortcut to get the frequency
     */
    public function getFrequency()
    {
        return $this->getOption('frequency');
    }

    /**
     * Shortcut to get the prefix
     */
    public function getPrefix()
    {
        return $this->getOption('prefix');
    }

    /**
     * Getting an option value
     */
    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }

        throw new \RuntimeException('Asking for non-existing option "'.$option.'"');
    }

    /**
     * @inherit
     */
    public function registerInput($index, $type)
    {
        return $this->register($this->global, 'input', $type, null, $index, true);
    }
    public function registerOutput($index, $type)
    {
        return $this->register($this->global, 'output', $type, null, $index, true);
    }
    public function registerState($blockId, $index, $type)
    {
        return $this->register($this->stack, 'state', $type, $blockId, $index);
    }
    public function registerVariable($blockId, $index, $type)
    {
        return $this->register($this->global, 'variable', $type, $blockId, $index, true);
    }
    
    /**
     * @inherit
     */
    public function inputName($index)
    {
        $identifier = $this->getIdentifier('input', null, $index);
        $this->checkRegistered($this->global, $identifier);
        return $identifier;
    }
    public function outputName($index)
    {
        $identifier = $this->getIdentifier('output', null, $index);
        $this->checkRegistered($this->global, $identifier);
        return $identifier;
    }
    public function stateName($blockId, $index)
    {
        $identifier = $this->getIdentifier('state', $blockId, $index);
        $this->checkRegistered($this->stack, $identifier);
        return $identifier;
    }
    public function variableName($blockId, $index)
    {
        $identifier = $this->getIdentifier('variable', $blockId, $index);
        $this->checkRegistered($this->global, $identifier);
        return $identifier;
    }

    /**
     * @inherit
     */
    public function inputType($index)
    {
        $identifier = $this->getIdentifier('input', null, $index);
        $this->checkRegistered($this->global, $identifier);
        return $this->global[$identifier];
    }
    public function outputType($index)
    {
        $identifier = $this->getIdentifier('output', null, $index);
        $this->checkRegistered($this->global, $identifier);
        return $this->global[$identifier];
    }
    public function stateType($blockId, $index)
    {
        $identifier = $this->getIdentifier('state', $blockId, $index);
        $this->checkRegistered($this->stack, $identifier);
        return $this->stack[$identifier];
    }
    public function variableType($blockId, $index)
    {
        $identifier = $this->getIdentifier('variable', $blockId, $index);
        $this->checkRegistered($this->global, $identifier);
        return $this->global[$identifier];
    }

    /**
     * Try to guess the type of the given numeric variable
     *
     * @return Rhoban\Blocks\VariableType
     */
    public function guestVariableType($value)
    {
        if (is_numeric($value)) {
            if (is_int($value) || ctype_digit($value)) {
                return VariableType::Integer;
            } else {
                return VariableType::Scalar;
            }
        } else {
            return VariableType::Other;
        }
    }

    /**
     * Build the variable identifier based on
     * its name, index and blockId
     * @param $name : string
     * @param $blockId : null or integer
     * @param $index : integer
     */
    protected function getIdentifier($name, $blockId, $index)
    {
        if ($blockId) {
            return $name.'_'.$blockId.'_'.$index;
        } else {
            return $name.'_'.$index;
        }
    }
    
    /**
     * Check if a variable is already registered in the given array
     * @param $array : the array to search in
     * @param $identifier : the variable identifier
     * @param $throwFounded : if true, an exception is throw if the
     * given variable is already register. If false, an exception
     * is throw if the variable is not founded
     */
    private function checkRegistered(array $array, $identifier, 
        $throwFounded = false)
    {
        if (array_key_exists($identifier, $array) && $throwFounded) {
            throw new \InvalidArgumentException(
                'Variable '.$identifier.' already registered');
        } else if (!array_key_exists($identifier, $array) && !$throwFounded) {
            throw new \InvalidArgumentException(
                'Variable '.$identifier.' is not registered');
        }
    }

    /**
     * Register a variable
     * @param $array : the container array 
     * @param $name : the variable type name
     * @param $type : Rhoban\Blocks\VariableType
     * @param $blockId
     * @param $index
     */
    private function register(array &$array, $name, $type, 
        $blockId = null, $index, $global = false)
    {
        $identifier = $this->getIdentifier($name, $blockId, $index);
        $this->checkRegistered($array, $identifier, true);
        $array[$identifier] = $type;

        return new Identifier($this, $identifier, $type, $global);
    }
}