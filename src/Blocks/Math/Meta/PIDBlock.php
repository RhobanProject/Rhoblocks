<?php

namespace Rhoban\Blocks\Blocks\Math\Meta;

use Rhoban\Blocks\Block;

abstract class PIDBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'PID',
            'family' => 'Math',
            'description' => 'PID regulator',
            'parameters' => array(
                array(
                    'name' => 'P',
                    'type' => 'number',
                    'default' => 0,
                ),
                array(
                    'name' => 'I',
                    'type' => 'number',
                    'default' => 0,
                ),
                array(
                    'name' => 'D',
                    'type' => 'number',
                    'default' => 0,
                ),
                array(
                    'name' => 'Discount',
                    'type' => 'number',
                    'default' => 0.8
                ),
                array(
                    'name' => 'IMin',
                    'type' => 'number',
                    'default' => -10
                ),
                array(
                    'name' => 'IMax',
                    'type' => 'number',
                    'default' => 10
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Order',
                    'type' => 'number',
                    'card' => '0-1',
                    'default' => 0
                ),
                array(
                    'name' => 'Actual',
                    'type' => 'number',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Command',
                    'type' => 'number',
                    'card' => '0-*',
                ),
                array(
                    'name' => 'Error',
                    'type' => 'number',
                    'card' => '0-*'
                )
            ),
        );
    }
}
