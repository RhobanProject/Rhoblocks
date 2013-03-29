<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\FactoryInterface;
use Rhoban\Blocks\Implementation\C\ConstantBlock_C;

/**
 * Factory
 */
class Factory implements FactoryInterface
{
    /**
     * Binding associations between implementation
     * family and Blocks classes and VariableHolder
     */
    private static $familyBinding = array(
        'C' => array(
            'Constant' => 'Rhoban\\Blocks\\Implementation\\C\\ConstantBlock_C',
            'Sinus' => 'Rhoban\\Blocks\\Implementation\\C\\SinusBlock_C',
            'HOLDER' => 'Rhoban\\Blocks\\Implementation\\C\\VariableHolder_C',
            'GENERATOR' => 'Rhoban\\Blocks\Implementation\\C\\Generator_C',
        ),
    );

    /**
     * The implementation family of the factory
     */
    private $family;

    /**
     * The variable holder and generator instance
     */
    private $generatorInstance = null;
    private $variableHolderInstance = null;

    /**
     * Initialize the Factory
     * @param $family : the implementation
     * family
     */
    public function __construct($family)
    {
        $this->family = $family;
    }

    /**
     * @inherit
     */
    public function getGenerator()
    {
        if (!$this->generatorInstance) {
            $this->generatorInstance = $this->newObject('GENERATOR');
        }

        return $this->generatorInstance;
    }

    /**
     * @inherit
     */
    public function getVariableHolder()
    {
        if (!$this->variableHolderInstance) {
            $this->variableHolderInstance = $this->newObject('HOLDER');
        }

        return $this->variableHolderInstance;
    }

    /**
     * @inherit
     */
    public function createBlock($type, $json)
    {
        return $this->newObject($type, $json, $this->getVariableHolder());
    }

    /**
     * @inherit
     */
    public function generateBlocksJSON()
    {
        $jsonContainer = array();
        foreach (self::$familyBinding[$this->family] as $type => $className) {
            if ($type != 'HOLDER' && $type != 'GENERATOR') {
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
        if (
            self::$familyBinding[$this->family] && 
            self::$familyBinding[$this->family][$type]
        ) {
            if ($arg1 && $arg2) {
                $className = self::$familyBinding[$this->family][$type];
                return new $className($arg1, $arg2);
            } else if ($arg1) {
                $className = self::$familyBinding[$this->family][$type];
                return new $className($arg1);
            } else {
                $className = self::$familyBinding[$this->family][$type];
                return new $className();
            }
        } else {
            throw new \RuntimeException(
                'Unknown '.$type.' for family '.$this->family);
        }
    }
}
