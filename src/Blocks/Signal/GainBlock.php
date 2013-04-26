<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class GainBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Gain',
            'family' => 'Signal',
            'description' => 'A simple gain',
            'parameters' => array(
                array(
                    'name' => 'Gain',
                    'default' => 2,
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Input',
                    'card' => '0-1',
                    'default' => 0
                )
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
