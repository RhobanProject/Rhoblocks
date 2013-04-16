<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class PulseBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Pulse',
        'family' => 'I/O',
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
                'card' => '0-*'
            )
        ),
    );
}
