<?php

namespace Rhoban\Blocks;

/**
 * FactoryInterface
 */
interface FactoryInterface
{
    /**
     * Get the Generator for code generation
     *
     * @return Rhoban\Blocks\GeneratorInterface
     */
    public function getGenerator();

    /**
     * Get the container for variables
     *
     * @return Rhoban\Blocks\EnvironmentInterface
     */
    public function getEnvironment();

    /**
     * Create a new Block from a given json representation
     * @param $type : string block type
     * @param $json : string json representation
     *
     * @return Rhoban\Blocks\BlockInterface
     */
    public function createBlock($type, $json);

    /**
     * Generate the JSON blocks definition for
     * blocks.js
     *
     * @return array of JSON definition
     */
    public function generateBlocksJSON();
}
