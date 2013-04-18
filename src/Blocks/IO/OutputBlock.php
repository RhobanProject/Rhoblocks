<?php

namespace Rhoban\Blocks\Blocks\IO;

use Rhoban\Blocks\Block;

abstract class OutputBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Output',
            'family' => 'I/O',
            'description' => 'Outputs to the output_N variable',
            'parameters' => array(
                array(
                    'name' => 'Index',
                    'type' => 'integer',
                    'card' => 0,
                    'default' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Value',
                    'card' => '0-1',
                ),
            ),
            'outputs' => array(),
        );
    }
}
