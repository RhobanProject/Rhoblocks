<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class SinusBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Sinus',
        'family' => 'Math',
        'description' => 'Outputs <b>sin(T+phase)*amplitude</b>',
        'parameters' => array(
            array(
                'name' => 'Amplitude',
                'type' => 'number',
                'default' => 1,
            ),
            array(
                'name' => 'Frequency',
                'type' => 'number',
                'unit' => 'Hz',
                'default' => 1,
            ),
            array(
                'name' => 'Phase',
                'type' => 'number',
                'unit' => '°',
                'default' => 0,
            ),
        ),
        'inputs' => array(
            array(
                'name' => 'T',
                'card' => '1',
            ),
        ),
        'outputs' => array(
            array(
                'name' => 'Wave',
                'card' => '0-*',
            ),
        ),
    );
}
