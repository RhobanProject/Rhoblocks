<?php

namespace Rhoban\Blocks;

/**
 * The family class describe which class should be used for the involved
 * blocks
 */
abstract class Family
{   
    // The family name
    protected $name;

    // Block definitions
    protected $blocks; 

    /**
     * Return all blocks of the family
     *
     * @return array the blocks, keys are type and values class names
     */
    abstract protected function getBlocks();

    public function __construct($name)
    {
        $this->name = $name;
        $this->blocks = $this->getBlocks();
    }

    /**
     * Get the family name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the class for the block type given by $blockType
     *
     * @param $blockType the type of the block
     *
     * @return string the name of the class that should be used
     */
    public function getClassFor($blockType)
    {
        if (isset($this->blocks[$blockType])) {
            return $this->blocks[$blockType];
        } else {
            return null;
        }
    }

    /**
     * Get the type of all blocks
     *
     * @return array an array containing all block types
     */
    public function getAllBlocks()
    {
        return $this->blocks;
    }

    /**
     * Car this family be generated
     */
    public function canBeGenerated()
    {
        return true;
    }
}
