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
    public function registerState($blockId, $index, $type)
    {
        return $this->register($this->stack, 'state', $type, $blockId, $index);
    }

    public function registerVariable($blockId, $index, $type)
    {
        return $this->register($this->global, 'variable', $type, $blockId, $index, true);
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
     * Creates an identifier
     */
    protected function createIdentifier($identifier, $type, $global = false)
    {
        return new Identifier($this, $identifier, $type);
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

        if (!isset($array[$identifier])) {
            $array[$identifier] = $this->createIdentifier($identifier, $type, $global);
        }

        return $array[$identifier];
    }
}
