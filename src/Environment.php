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
     * Setting the value of an option
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * @inherit
     */
    public function registerState($name, $index, $type, $dimension = 0)
    {
        return $this->register($this->global, 'state', $type, $dimension, $name, $index, true);
    }

    public function registerVariable($name, $index, $type, $dimension = 0)
    {
        return $this->register($this->stack, 'variable', $type, $dimension, $name, $index);
    }

    public function registerGlobal($name, $index, $type, $dimension = 0)
    {
        return $this->register($this->global, $name, $type, $dimension, $index, null, true);
    }

    /**
     * Build the variable identifier based on
     * its name, index and name
     * @param $name : string
     * @param $name : null or integer
     * @param $index : integer
     */
    protected function getIdentifier($name, $varName, $index)
    {
        if ($index) {
            return $name.'_'.$varName.'_'.$index;
        } else {
            return $name.'_'.$varName;
        }
    }

    /**
     * Creates an identifier
     */
    protected function createIdentifier($identifier, $type, $dimension, $global = false)
    {
        return new Identifier($this, $identifier, $type, $dimension);
    }
    
    /**
     * Register a variable
     * @param $array : the container array 
     * @param $name : the variable type name
     * @param $type : Rhoban\Blocks\VariableType
     * @param $name
     * @param $index
     */
    private function register(array &$array, $name, $type, $dimension, $varName = null, $index, $global = false)
    {
        $identifier = $this->getIdentifier($name, $varName, $index);

        if (!isset($array[$identifier])) {
            $array[$identifier] = $this->createIdentifier($identifier, $type, $dimension, $global);
        }

        return $array[$identifier];
    }
}
