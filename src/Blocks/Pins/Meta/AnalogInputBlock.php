<?php

namespace Rhoban\Blocks\Blocks\Pins\Meta;

use Rhoban\Blocks\Block;

abstract class AnalogInputBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'AnalogInput',
            'family' => 'Pins',
            'description' => 'Inputs a digital value to a pin (off/on)',
            'parameters' => array(
                array(
                    'name' => 'Pin',
                    'type' => 'text',
                    'default' => 1,
                    'card' => 0
                ),
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
