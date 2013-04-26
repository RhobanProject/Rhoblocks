<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class MinBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Min',
            'family' => 'Math',
            'description' => 'Output is the minimum of terms',
            'parameters' => array(),
            'inputs' => array(
                array(
                    'name' => 'Terms',
                    'card' => '0-*'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Min',
                    'card' => '0-*',
                )
            ),
        );
    }
}
