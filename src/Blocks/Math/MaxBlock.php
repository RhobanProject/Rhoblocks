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
            'parameters' => array(
                array(
                    'name' => 'Terms',
                    'type' => 'integer',
                    'default' => 2,
                    'card' => 0,
                    'hide' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Term #',
                    'card' => '0-1',
                    'default' => 0,
                    'length' => 'Terms.value'
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
