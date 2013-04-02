<?php

namespace Rhoban\Blocks;

/**
 * GeneratorInterface
 */
interface GeneratorInterface
{
    /**
     * Return an array of generated code
     * files for transition computation
     * @param $structCode : implementation of structure
     * declaration code
     * @param $initCode : implementation code of 
     * initialisation function
     * @param $initTransitionCode : implementation code 
     * of stack initialisation
     * @param $transitionCode : implementation code of
     * transition function
     *
     * @return array of string code
     */
    public function generateCode(EnvironmentInterface $environment, $initCode, $transitionCode);

    /**
     * Return 
     * @return array of string code
     */
    public function generateMain();
}
