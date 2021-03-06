<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\BlockInterface;

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
        $io = explode('_', $io, 2);

        if (count($io) == 2) {
            if (in_array($io[0], $patterns)) {
                if (strpos($io[1], '_') !== false) {
                    $io[1] = explode('_', $io[1], 2);
                    $io[1][0] = (int) $io[1][0];
                    $io[1][1] = (int) $io[1][1];
                } else {
                    $io[1] = array((int) $io[1]);
                }

                if ($io[1][0] >= 0) {
                    return $io;
                }
            }
        }

        throw new \RuntimeException('The io "'.$io.'" is not correct');
    }

    /**
     * Should this edge be ignored in loop testing ?
     */
    public function isLoopable()
    {
        return ($this->blockFrom->isLoopable());
    }

    /**
     * Apply the inversed transformation convertIo
     * @param $ioArray formated as array('input', 12)
     *
     * @return string io name 'input_12'
     */
    public static function reverseIo($ioArray)
    {
        $ioArray[1] = implode('_', $ioArray[1]);

        return implode('_', $ioArray);
    }

    /**
     * Initialize the edge
     * @param $blockFrom Rhoban\Blocks\BlockInterface source block
     * @param $ioFrom string source io label
     * @param $blockTo Rhoban\Blocks\BlockInterface destination block
     * @param $ioTo string destination io label
     */
    public function __construct
        (BlockInterface $blockFrom, $ioFrom, BlockInterface $blockTo, $ioTo)
    {
        $this->blockFrom = $blockFrom;
        $this->ioFrom = static::convertIo($ioFrom);
        $this->blockTo = $blockTo;
        $this->ioTo = static::convertIo($ioTo);
    }

    /**
     * Getters
     */
    public function fromId()
    {
        return (int) $this->blockFrom->getId();
    }
    public function toId()
    {
        return (int) $this->blockTo->getId();
    }

    /**
     * The I/O name of the output
     */
    public function outputName()
    {
        return static::reverseIo($this->ioTo);
    }

    /**
     * The I/O name of the input
     */
    public function inputName()
    {
        return static::reverseIo($this->ioFrom);
    }

    /**
     * The I/O name for the given block
     * @param Rhoban\Blocks\BlockInterface
     */
    public function ioSection(BlockInterface $block)
    {
        if ($block == $this->blockFrom) {
            $section = $this->ioFrom;
        } else {
            $section = $this->ioTo;
        }

        if ($section[0] == 'param') {
            $section[0] = 'parameter';
        }

        return $section;
    }

    /**
     * The I/O name for the given block
     * @param Rhoban\Blocks\BlockInterface
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
     * Returns the number of the section for the destination
     */
    public function getTargetSection()
    {
        return $this->ioTo;
    }

    /**
     * Gets the identifier of the inputting block
     *
     */
    public function inputIdentifier()
    {
        return $this->blockFrom->getOutputIdentifier($this->ioFrom[1], true);
    }
}
