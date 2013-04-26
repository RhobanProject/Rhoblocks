<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class PulseBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Pulse',
            'family' => 'Signal',
            'description' => 'Send pulses',
            'parameters' => array(
                array(
                    'name' => 'Frequency',
                    'type' => 'number',
                    'unit' => 'Hz',
                    'default' => '1'
                )
            ),
            'inputs' => array(),
            'outputs' => array(
                array(
                    'name' => 'Pulse',
                    'card' => '0-*',
                    'type' => 'integer'
                )
            ),
        );
    }
}
