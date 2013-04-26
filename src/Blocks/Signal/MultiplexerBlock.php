<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class MultiplexerBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
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
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 0
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
}
