<?php

namespace Rhoban\Blocks\Blocks\Signal\Meta;

use Rhoban\Blocks\Block;

abstract class DemultiplexerBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Demultiplexer',
            'family' => 'Signal',
            'description' => 'Sets the nth output to 1',
            'parameters' => array(
                array(
                    'name' => 'Outputs',
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
                ),
                array(
                    'name' => 'Value',
                    'default' => '1'
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'N',
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Output #',
                    'length' => 'Outputs.value',
                    'card' => '0-*'
                ),
            ),
        );
    }
}
