<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class MinMaxBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'MinMax',
            'family' => 'Math',
            'description' => 'Bounds the input between min & max',
            'parameters' => array(
                array(
                    'name' => 'Min',
                    'default' => 0
                ),
                array(
                    'name' => 'Max',
                    'default' => 10
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Input',
                    'card' => '0-1',
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
