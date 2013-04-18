<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\FactoryInterface;
use Rhoban\Blocks\Family;

/**
 * Factory
 */
class Factory implements FactoryInterface
{
    /**
     * Binding associations between implementation
     * family and Blocks classes and Environment
     */
    private static $families = array('C', 'Arduino');

    /**
     * The implementation family of the factory
     */
    private $family;

    /**
     * The environment and generator instance
     */
    private $generatorInstance = null;
    private $environmentInstance = null;

    /**
     * The specific options to use
     */
    protected $options;

    /**
     * Get a class name regarding the project convention
     */
    protected function getClassName($family, $className)
    {
         return 'Rhoban\\Blocks\\Implementation\\'.$family.'\\'.$className;
    }

    /**
     * Initialize the Factory
     * @param $family : the implementation
     * family
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['family'])) {
            throw new \RuntimeException('No family given');
        }

        $family = $options['family'];

        if (!in_array($family, self::$families)) {
            throw new \RuntimeException('Unknown family: '.$family);
        }

        $class = $this->getClassName($family, 'Family');
        $this->family = new $class($family);

        if (!$this->family instanceof Family) {
            throw new \RuntimeException('The family for '.$family.' should extends Family');
        }
        
        $generator = $class = $this->getClassName($family, 'Generator');
        $this->generatorInstance = new $generator;

        $environment = $class = $this->getClassName($family, 'Environment');
        $this->environmentInstance = new $environment($options);

        $this->options = $options;
    }

    /**
     * @inherit
     */
    public function getGenerator()
    {
        return $this->generatorInstance;
    }

    /**
     * @inherit
     */
    public function getEnvironment()
    {
        return $this->environmentInstance;
    }

    /**
     * @inherit
     */
    public function createBlock($type, $json)
    {
        return $this->newObject($type, $json, $this->getEnvironment());
    }

    /**
     * @inherit
     */
    public function generateBlocksJSON()
    {
        $jsonContainer = array();
        $blocks = $this->family->getAllBlocks();

        foreach ($blocks as $type => $className) {
            if ($type != 'ENVIRONMENT' && $type != 'GENERATOR') {
                $jsonContainer[$type] = $className::generateJSON();
            }
        }

        return $jsonContainer;
    }
    
    /**
     * Create a new instance of the given class according with
     * family binding configuration
     * @param $type : the class alias in family binding
     * @param $arg1 : a parameter to give to the instance if defined
     * @param $arg2 : a parameter to give to the instance if defined
     *
     * @return object
     */
    private function newObject($type, $arg1 = null, $arg2 = null)
    {
        $className = $this->family->getClassFor($type);

        if ($className) {

            if ($arg1 !== null && $arg2 !== null) {
                return new $className($arg1, $arg2);
            } else if ($arg1 !== null) {
                return new $className($arg1);
            } else {
                return new $className();
            }
        } else {
            throw new \RuntimeException('Unknown '.$type.' for family '.$this->family->getName());
        }
    }
}
