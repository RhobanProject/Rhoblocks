<?php

namespace Rhoban\Blocks\Blocks\Math\Meta;

use Rhoban\Blocks\Block;

abstract class DerivateBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Derivate',
            'family' => 'Math',
            'description' => 'Derivates of the input',
            'parameters' => array(
                array(
                    'name' => 'Discount',
                    'default' => 0.8,
                    'type' => 'number'
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Signal',
                    'card' => '0-1',
                    'default' => 0
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Derivate',
                    'type' => 'number',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
