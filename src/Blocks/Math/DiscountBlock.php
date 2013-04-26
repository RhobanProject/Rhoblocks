<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class DiscountBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Discount',
            'family' => 'Math',
            'description' => 'Bounds the input variation',
            'parameters' => array(
                array(
                    'name' => 'Factor',
                    'type' => 'number',
                    'default' => 0.9
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
                    'type' => 'number',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
