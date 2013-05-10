<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\Module;
use Rhoban\Blocks\Blocks\IO\IOModule;
use Rhoban\Blocks\Blocks\Logic\LogicModule;
use Rhoban\Blocks\Blocks\Loop\LoopModule;
use Rhoban\Blocks\Blocks\Math\MathModule;
use Rhoban\Blocks\Blocks\Signal\SignalModule;
use Rhoban\Blocks\Blocks\Time\TimeModule;

/**
 * The kernel holds all the modules that can be used
 */
abstract class Kernel
{
    // Block modules
    protected $modules;

    // Options
    protected $options;

    public function __construct(array $options = array())
    {
        $this->options = $options;

        $this->addModule(new IOModule);
        $this->addModule(new LogicModule);
        $this->addModule(new LoopModule);
        $this->addModule(new MathModule);
        $this->addModule(new SignalModule);
        $this->addModule(new TimeModule);

        $this->environmentInstance = $this->createEnvironment();
        $this->generatorInstance = $this->createGenerator();
        $this->init();
    }

    protected function init()
    {
    }

    /**
     * Gets the metas of all modules blocks that are supported
     * and which class exists for the current implementation
     *
     * @return array all the type => meta blocks
     */
    public function getBlocks()
    {
        $metas = array();

        foreach ($this->modules as $module) {
            $blocks = $module->getAllMetas();

            foreach ($blocks as $name => $meta) {
                if ($this->supportsBlock($name, $module->getName())) {
                    $meta['module'] = $module->getName();
                    $metas[$name] = $meta;
                }
            }
        }

        return $metas;
    }

    /**
     * Returns the module of a block
     *
     * @param string the block type
     *
     * @return Module the module of the given block
     */
    public function getBlockModule($block)
    {
        foreach ($this->modules as $module) {
            if ($module->hasBlock($block)) {
                return $module;
            }
        }

        return null;
    }

    /**
     * Gets the Kernel target name
     *
     * @return string the name of the target
     */
    abstract function getName();

    /**
     * Add a module to the kernel
     *
     * @param Module the module that is registered
     */
    public function addModule(Module $module)
    {
        $this->modules[$module->getName()] = $module;
    }

    /**
     * Gets all the modules of this kernel
     *
     * @return array of Module
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Generate all the blocks JSON
     */
    public function generateBlocksJSON()
    {
        $blocks = $this->getBlocks();

        foreach ($blocks as $name => &$meta) {
            $meta = json_encode($meta);
        }

        return $blocks;
    }

    /**
     * Can all the modules of this kernel be generated for a compiler?
     *
     * @return bool true if this kernel can be compiled
     */
    public function canBeCompiled()
    {
        return false;
    }

    /**
     * Gets the environment for this kernel
     * 
     * @return an environment
     */
    public function getEnvironment()
    {
        return $this->environmentInstance;
    }

    /**
     * Gets the generator for 
     *
     * @return a suitable generator
     */
    public function getGenerator()
    {
        return $this->generatorInstance;
    }

    /**
     * Gets the environment for this kernel
     * 
     * @return an environment
     */
    public function createEnvironment()
    {
        return null;
    }

    /**
     * Gets the generator for 
     *
     * @return a suitable generator
     */
    public function createGenerator()
    {
        return null;
    }

    /**
     * Gets the class for a block on a certain target
     */
    protected function classForBlockTarget($target, $block, $module)
    {
        if (!isset($this->modules[$module])) {
            throw new \RuntimeException('The module "'.$module.'" is not loaded');
        }

        $module = $this->modules[$module];

        if ($module->hasBlock($block)) {
            $className = $module->getImplementation($block, $target);

            if (class_exists($className)) {
                return $className;
            }
        }

        return null;
    }

    /**
     * Returns the class name for the given block
     */
    protected function classForBlock($block, $module)
    {
        return $this->classForBlockTarget($this->getName(), $block, $module);
    }

    /**
     * Creates a block
     */
    public function createBlock($block, array $data)
    {
        if (!isset($data['module'])) {
            throw new \RuntimeException('Block '.$block.' without module');
        }

        $module = $data['module'];

        $className = $this->classForBlock($block, $module);

        if ($className) {
            return new $className($data, $this->getEnvironment());
        }

        return null;
    }

    /**
     * Does the Kernel supports this block ?
     *
     * @return bool true if the block is supported
     */
    public function supportsBlock($block, $module)
    {
        return $this->classForBlock($block, $module) != null;
    }
}
