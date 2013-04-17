<?php

namespace Rhoban\Blocks\Blocks\Time;

use Rhoban\Blocks\Block;

abstract class DelayBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Delay',
        'family' => 'Time',
        'description' => 'Outputs its inputs with a given delay',
        'parameters' => array(
            array(
                'name' => 'Delay',
                'unit' => 's',
                'default' => 1,
                'card' => 0
            ),
            array(
                'name' => 'Default',
                'card' => 0,
                'default' => 0
            )
        ),
        'inputs' => array(
            array(
                'name' => 'Input',
                'card' => '0-1',
                'default' => 0
            )
        ),
        'outputs' => array(
            array(
                'name' => 'Output',
                'card' => '0-*'
            ),
        ),
    );
}
