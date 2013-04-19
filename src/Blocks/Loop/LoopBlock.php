<?php

namespace Rhoban\Blocks\Blocks\Loop;

use Rhoban\Blocks\Block;

abstract class LoopBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Loop',
            'family' => 'Loop',
            'description' => 'Allows looping',
            'loopable' => true,
            'parameters' => array(
                array(
                    'name' => 'Default',
                    'default' => 0,
                    'card' => 0
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Input',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Output',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
