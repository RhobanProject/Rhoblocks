<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class PWMBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'PWM',
            'family' => 'Signal',
            'description' => 'Outputs a PWM',
            'parameters' => array(
                array(
                    'name' => 'Duty',
                    'default' => 50,
                ),
                array(
                    'name' => 'Frequency',
                    'default' => 1,
                    'unit' => 'hz'
                ),
            ),
            'inputs' => array(),
            'outputs' => array(
                array(
                    'name' => 'PWM',
                    'type' => 'integer',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
