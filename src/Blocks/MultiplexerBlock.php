<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class MultiplexerBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Multiplexer',
        'family' => 'Signal',
        'description' => 'Outputs the nth input',
        'parameters' => array(
            array(
                'name' => 'Inputs',
                'default' => 2,
                'type' => 'integer',
                'card' => 0
            ),
            array(
                'name' => 'FallbackValue',
                'default' => 0
            ),
            array(
                'name' => 'Cyclic',
                'type' => 'check',
                'default' => false
            )
        ),
        'inputs' => array(
            array(
                'name' => 'N',
                'type' => 'integer'
            ),
            array(
                'name' => 'Input #',
                'length' => 'Inputs.value'
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
