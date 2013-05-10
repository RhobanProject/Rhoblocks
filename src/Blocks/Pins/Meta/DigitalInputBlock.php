<?php

namespace Rhoban\Blocks\Blocks\Pins\Meta;

use Rhoban\Blocks\Block;

abstract class DigitalInputBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'DigitalInput',
            'family' => 'Pins',
            'description' => 'Inputs a digital value to a pin (off/on)',
            'parameters' => array(
                array(
                    'name' => 'Pin',
                    'type' => 'text',
                    'default' => 1,
                    'card' => 0
                ),
                array(
                    'name' => 'Pull-Up',
                    'type' => 'check',
                    'default' => true,
                    'card' => 0
                ),
                array(
                    'name' => 'Invert',
                    'type' => 'check',
                    'default' => true
                )
            ),
            'inputs' => array(
            ),
            'outputs' => array(
                array(
                    'name' => 'Level',
                    'type' => 'integer',
                    'card' => '0-*'
                ),
            ),
        );
    }
}
