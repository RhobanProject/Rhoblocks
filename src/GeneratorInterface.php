<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\EnvironmentInterface;

/**
 * GeneratorInterface
 */
interface GeneratorInterface
{
    /**
     * Return an array of generated code
     * files for transition computation
     * @param $environment : Rhoban\Blocks\EnvironmentInterface
     * variables environment
     * @param $initCode : implementation code of 
     * initialisation function
     * @param $initTransitionCode : implementation code 
     * of stack initialisation
     * @param $transitionCode : implementation code of
     * transition function
     *
     * @return array of string code
     */
    public function generateCode
        (EnvironmentInterface $environment, $initCode, $transitionCode);
}
