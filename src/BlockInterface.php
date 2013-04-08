<?php

namespace Rhoban\Blocks;

interface BlockInterface
{
    /**
     * Generate the json description of the block
     * for blocks.js
     *
     * @return json string
     */
    public static function generateJSON();

    /**
     * Generate the initialisation and implementation code
     * (must be called in topological order)
     * @param $linksReversed : array of incomming edges
     *
     * @return code string
     */
    public function generateInitCode();
    public function generateTransitionCode();

    /**
     * Return the id of the block
     *
     * @return integer
     */
    public function getId();

    /**
     * Return array META informations
     *
     * @return array
     */
    public function getMeta();
}
