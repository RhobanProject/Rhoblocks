<?php

namespace Rhoban\Blocks\Blocks\Math\Meta;

use Rhoban\Blocks\Block;

abstract class MinBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Min',
            'family' => 'Math',
            'description' => 'Output is the minimum of terms',
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
                    'card' => '0-1',
                    'length' => 'Terms.value',
                    'default' => 0
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Min',
                    'card' => '0-*',
                )
            ),
        );
    }
}
