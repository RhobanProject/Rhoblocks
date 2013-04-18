<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class VariationBoundBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'VariationBound',
            'family' => 'Math',
            'description' => 'Bounds the input variation',
            'parameters' => array(
                array(
                    'name' => 'Limit',
                    'default' => 1,
                    'unit' => '/s'
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Input',
                    'card' => '0-1',
                    'type' => 'number',
                    'default' => '0'
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
