<?php

namespace Rhoban\Blocks;

/**
 * The family class describe which class should be used for the involved
 * blocks
 */
abstract class Module
{
    /**
     * Gets the module namie
     */
    public function getName()
    {
        $parts = explode('\\', get_class($this));
        $last = $parts[count($parts)-1];

        if (preg_match('#^(.+)Module$#', $last, $matches)) {
            return $matches[1];
        }

        throw new \RuntimeException('No name for the module ('.get_class($this).')');
    }

    /**
     * Get all the blocks supported by the module
     */
    public function getBlocks()
    {
        $blocks = array();
        $dir = opendir($this->getDirectory().'/Meta/');

        while ($file = readdir($dir)) {
            if (preg_match('#^(.*)Block\.php$#', $file, $matches)) {
                $blocks[] = $matches[1];
            }
        }

        closedir($dir);

        return $blocks;
    }

    /**
     * Get the prefix (namespace) of the module class
     *
     * @return string the prefix, i.e Rhoban\Blocks\Signal
     */
    public function getPrefix()
    {
        $parts = explode('\\', get_class($this));
        unset($parts[count($parts)-1]);

        return implode('\\', $parts);
    }

    /**
     * Gets the meta class of a given block
     *
     * @param string the block name
     *
     * @return string the name of the meta class
     */
    public function getClass($block)
    {
        if (!$this->hasBlock($block)) {
            throw new \RuntimeException('No meta for the block '.$block);
        }

        return $this->getPrefix().'\\Meta\\'.$block.'Block';
    }

    /**
     * Gets the meta of a block
     *
     * @param string the name of the block
     *
     * @return array all the metas
     */
    public function getMeta($block)
    {
        $className = $this->getClass($block);

        return $className::meta();
    }

    /**
     * Gets all blocks and their meta
     *
     * @return array all the block => meta
     */
    public function getAllMetas()
    {
        $metas = array();

        foreach ($this->getBlocks() as $block) {
            $metas[$block] = $this->getMeta($block);
        }

        return $metas;
    }

    /**
     * Gets the implementation directory for a given target
     *
     * @param string block the block name
     * @param string target the target architecture
     *
     * @return string the block implementation class for this target
     */
    public function getImplementation($block, $target)
    {
        if (!$this->hasBlock($block)) {
            throw new \RuntimeException('No meta for the block '.$block);
        }

        return $this->getPrefix().'\\'.$target.'\\'.$block.'Block';
    }

    /**
     * Is block handled by this module ?
     *
     * @param string the block name
     *
     * @return bool true if the block is handled
     */
    public function hasBlock($block)
    {
        return in_array($block, $this->getBlocks());
    }

    /**
     * Gets the directory
     *
     * @return string a string of the directory, for the interpreter
     */
    public function getDirectory()
    {
        $reflection = new \ReflectionClass($this);

        return dirname($reflection->getFilename());
    }
}
