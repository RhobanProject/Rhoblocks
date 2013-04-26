<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class SquareBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Square',
            'family' => 'Signal',
            'description' => 'Outputs a Square',
            'parameters' => array(
                array(
                    'name' => 'Duty',
                    'default' => 50,
                    'unit' => '%'
                ),
                array(
                    'name' => 'Frequency',
                    'default' => 1,
                    'unit' => 'hz'
                ),
            ),
            'inputs' => array(),
            'outputs' => array(
                array(
                    'name' => 'Square',
                    'type' => 'integer',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
