<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class ExpressionBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Expression',
            'family' => 'Math',
            'description' => 'A raw expression',
            'parameters' => array(
                array(
                    'name' => 'Expression',
                    'hideLabel' => true,
                    'type' => 'text',
                    'card' => 0,
                    'hide' => true
                ),
                array(
                    'name' => 'Inputs',
                    'type' => 'integer',
                    'default' => 1,
                    'hide' => true,
                    'card' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'X#',
                    'card' => '0-1',
                    'default' => 0,
                    'length' => 'Inputs.value'
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Result',
                    'card' => '0-*'
                ),
            ),
        );
    }
}
