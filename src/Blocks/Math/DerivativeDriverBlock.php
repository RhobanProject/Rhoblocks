<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class DerivativeDriverBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'DerivativeDriver',
            'family' => 'Math',
            'description' => 'A value driveable by its derrivate',
            'parameters' => array(
                array(
                    'name' => 'Default',
                    'type' => 'number',
                    'default' => 0,
                ),
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
                    'name' => 'Derivate',
                    'card' => '0-1',
                    'default' => 0
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Value',
                    'type' => 'number',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
