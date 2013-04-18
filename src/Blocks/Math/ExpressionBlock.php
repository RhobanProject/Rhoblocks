<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class ExpressionBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Expression',
            'family' => 'Math',
            'description' => 'A raw expression',
            'parameters' => array(
                array(
                    'name' => 'Expression',
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
                    'name' => 'X#',
                    'card' => '0-1',
                    'length' => 'Inputs.value'
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Result',
                    'card' => '0-*',
                    'type' => 'number'
                ),
            ),
        );
    }
}
