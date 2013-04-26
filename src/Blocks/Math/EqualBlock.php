<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class EqualBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Equal',
            'family' => 'Math',
            'description' => 'The < comparator',
            'parameters' => array(
                array(
                    'name' => 'Delta',
                    'default' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'A',
                    'card' => '0-1',
                    'default' => 0
                ),
                array(
                    'name' => 'B',
                    'card' => '0-1',
                    'default' => 0
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'A=B',
                    'type' => 'integer',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
