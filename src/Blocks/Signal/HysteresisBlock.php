<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class HysteresisBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Hysteresis',
            'family' => 'Signal',
            'description' => 'Hysteresis detector',
            'parameters' => array(
                array(
                    'name' => 'Default',
                    'type' => 'integer',
                    'default' => '0',
                    'card' => 0
                ),
                array(
                    'name' => 'Min',
                    'default' => 0
                ),
                array(
                    'name' => 'Max',
                    'default' => 1
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
                    'name' => 'Output',
                    'type' => 'integer',
                    'card' => '0-*'
                )
            ),
        );
    }
}
