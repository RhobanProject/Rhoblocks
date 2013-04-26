<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class MaxBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Max',
            'family' => 'Math',
            'description' => 'Output is the maximum of terms',
            'parameters' => array(),
            'inputs' => array(
                array(
                    'name' => 'Terms',
                    'card' => '0-*'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Max',
                    'card' => '0-*',
                )
            ),
        );
    }
}
