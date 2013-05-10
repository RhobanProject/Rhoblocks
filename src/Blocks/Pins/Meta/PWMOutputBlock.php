<?php

namespace Rhoban\Blocks\Blocks\Pins\Meta;

use Rhoban\Blocks\Block;

abstract class PWMOutputBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'PWMOutput',
            'family' => 'Pins',
            'description' => 'Outputs a pwm value on the pin',
            'parameters' => array(
                array(
                    'name' => 'Pin',
                    'type' => 'text',
                    'default' => 1,
                    'card' => 0
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Level',
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(),
        );
    }
}
