<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\FactoryInterface;
use Rhoban\Blocks\Graph;

/**
 * Compiler
 */
class Compiler
{
    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     *@var string
     */
    protected $jsonData;

    /**
     * Instanciates a compiler
     */
    public function __construct(Kernel $kernel, $jsonData = null)
    {
        $this->kernel = $kernel;
        $this->jsonData = $jsonData;
    }

    /**
     * Seets
     */
    public function setJSONData($jsonData = null)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * Generate JSON block definitions for blocks.js
     *
     * @return array of json blocks definition
     */
    public function generateJSON()
    {
        return $this->kernel->generateBlocksJSON();
    }

    /**
     * Generate the Blocks code files
     *
     * @return array of string code
     */
    public function generateCode()
    {
        if ($this->kernel->canBeCompiled()) {
            $graph = new Graph($this->jsonData, $this->kernel);
            $initCode = $graph->generateInitCode();
            $transitionCode = $graph->generateTransitionCode();

            $generator = $this->kernel->getGenerator();

            return $generator->generateCode(
                $this->kernel->getEnvironment(),
                $initCode,
                $transitionCode
            );
        } else {
            return array();
        }
    }
}
