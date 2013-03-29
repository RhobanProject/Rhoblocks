<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\Factory;
use Rhoban\Blocks\Graph;

/**
 * Compiler
 */
class Compiler
{
    /**
     * Generate JSON block definitions for blocks.js
     * @param $family : the implementation family (string)
     *
     * @return array of json blocks definition
     */
    public static function generateJSON($family = 'C')
    {
        $factory = new Factory($family);

        return $factory->generateBlocksJSON();
    }

    /**
     * Generate the Blocks code files
     * @param $family : the implementation family (string)
     * @param $jsonData : the json string from blocks.js to compile
     *
     * @return array of string code
     */
    public static function generateCode($jsonData, $family = 'C')
    {
        $factory = new Factory($family);
        $graph = new Graph($jsonData, $factory);
        $initCode = $graph->generateInitCode();
        $transitionCode = $graph->generateTransitionCode();
        $initTransitionCode = $factory->getVariableHolder()
            ->generateInitTransitionCode();
        $structCode = $factory->getVariableHolder()->generateStructCode();

        return $factory->getGenerator()->generateCode(
            $structCode, 
            $initCode, 
            $initTransitionCode, 
            $transitionCode);
    }

    /**
     * Generate main code files
     * @param $family : the implementation family (string)
     * @return array of string code
     */
    public static function generateMain($family = 'C')
    {
        $factory = new Factory($family);

        return $factory->getGenerator()->generateMain();
    }
}
