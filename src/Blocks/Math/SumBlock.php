<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class SumBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Sum',
            'family' => 'Math',
            'description' => 'Output is the maximum of terms',
            'parameters' => array(
                array(
                    'name' => 'Terms',
                    'type' => 'integer',
                    'default' => 2,
                    'card' => 0,
                    'hide' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Term #',
                    'length' => 'Terms.value',
                    'default' => 0,
                    'card' => '0-1'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Sum',
                        'card' => '0-*',
                )
            ),
        );
    }
}
