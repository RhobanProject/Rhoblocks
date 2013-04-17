<?php

namespace Rhoban\Blocks\Blocks\IO;

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
                'name' => 'Format',
                'type' => 'text',
                'card' => 0
            ),
            array(
                'name' => 'Inputs',
                'type' => 'integer',
                'default' => 1,
                'card' => 0
            )
        ),
        'inputs' => array(
            array(
                'name' => 'Trigger',
                'type' => 'integer',
                'card' => '0-1',
                'default' => 0
            ),
            array(
                'name' => 'Value #',
                'card' => '0-1',
                'length' => 'Inputs.value'
            ),
        ),
        'outputs' => array(),
    );
}