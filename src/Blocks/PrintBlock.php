<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class PrintBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Print',
        'family' => 'I/O',
        'description' => 'Print all the inputs',
        'parameters' => array(
            array(
                'name' => 'Inputs',
                'type' => 'integer',
                'default' => 1
            ),
            array(
                'name' => 'Frequency',
                'type' => 'number',
                'default' => '1'
            )
        ),
        'inputs' => array(
            array(
                'name' => 'Value #',
                'card' => '0-1',
                'length' => 'Inputs.value'
            ),
        ),
        'outputs' => array(),
    );
}
