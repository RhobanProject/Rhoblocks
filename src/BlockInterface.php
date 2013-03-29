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
    public function generateTransitionCode(array $linksReversed);

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

    /**
     * Return the minimum and maximum cardinality
     * for the given input/output/parameter
     * @param $index : integer index
     *
     * @return null if not bound or integer
     */
    public function getMinCardInput($index);
    public function getMaxCardInput($index);
    public function getMinCardOutput($index);
    public function getMaxCardOutput($index);
    public function getMinCardParam($index);
    public function getMaxCardParam($index);
}
