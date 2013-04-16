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
     * @var FactoryInterface
     */
    protected $factory;

    /**
     *@var string
     */
    protected $jsonData;

    /**
     * Instanciates a compiler
     */
    public function __construct(FactoryInterface $factory, $jsonData = null)
    {
        $this->factory = $factory;
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
    public  function generateJSON()
    {
        return $this->factory->generateBlocksJSON();
    }

    /**
     * Generate the Blocks code files
     *
     * @return array of string code
     */
    public function generateCode()
    {
        $graph = new Graph($this->jsonData, $this->factory);
        $initCode = $graph->generateInitCode();
        $transitionCode = $graph->generateTransitionCode();

        return $this->factory->getGenerator()->generateCode(
            $this->factory->getEnvironment(),
            $initCode, 
            $transitionCode
        );
    }
}
