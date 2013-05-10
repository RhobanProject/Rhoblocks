<?php

namespace Rhoban\Blocks\Blocks\Pins\Meta;

use Rhoban\Blocks\Block;

abstract class DigitalOutputBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'DigitalOutput',
            'family' => 'Pins',
            'description' => 'Outputs a digital value to a pin (off/on)',
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
