<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\BlockInterface;
use Rhoban\Blocks\EnvironmentInterface;

/**
 * An edge links a block io t/o another block i/o
 */
class Edge
{
    /**
     * The source block and its I/O
     */
    protected $blockFrom;
    protected $ioFrom;

    /**
     * The target block and its I/O
     */
    protected $blockTo;
    protected $ioTo;

    /**
     * Converts an I/O like "input_12" to an array like array('input', 12) and
     * do the checks that matters
     *
     * @param $io the io string
     *
     * @return array the io array
     */
    public static function convertIo($io)
    {
        $patterns = array('input', 'output', 'param');
        $io = explode('_', $io);

        if (count($io) == 2) {
            if (in_array($io[0], $patterns)) {
                $io[1] = (int)$io[1];

                if ($io[1] >= 0) {
                    return $io;
                }
            }
        }

        throw new \RuntimeException('The io "'.$io.'" is not correct');
    }

    public function __construct(BlockInterface $blockFrom, $ioFrom, BlockInterface $blockTo, $ioTo)
    {
        $this->blockFrom = $blockFrom;
        $this->ioFrom = static::convertIo($ioFrom);
        $this->blockTo = $blockTo;
        $this->ioTo = static::convertIo($ioTo);
    }

    public function fromId()
    {
        return (int)$this->blockFrom->getId();
    }

    public function toId()
    {
        return (int)$this->blockTo->getId();
    }

    /**
     * The I/O name of the output
     */
    public function outputName()
    {
        return implode('_', $this->ioTo);
    }

    /**
     * The I/O name of the input
     */
    public function inputName()
    {
        return implode('_', $this->ioFrom);
    }

    /**
     * The I/O name for the given block
     */
    public function ioName(BlockInterface $block)
    {
        if ($block == $this->blockFrom) {
            return $this->inputName();
        } else {
            return $this->outputName();
        }
    }

    /**
     * Is this edge entering in the given block ?
     */
    public function isEnteringIn(BlockInterface $block)
    {
        return ($this->blockTo == $block);
    }

    /**
     * Gets the identifier of the inputting block
     */
    public function inputIdentifier()
    {
        return $this->blockFrom->getOutputIdentifier($this->ioFrom[1], true);
    }
}
