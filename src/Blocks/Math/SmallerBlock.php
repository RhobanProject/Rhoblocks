<?php

namespace Rhoban\Blocks\Blocks\Math;

use Rhoban\Blocks\Block;

abstract class SmallerBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Smaller',
            'family' => 'Math',
            'description' => 'The < comparator',
            'parameters' => array(
            ),
            'inputs' => array(
                array(
                    'name' => 'A',
                    'card' => '1'
                ),
                array(
                    'name' => 'B',
                    'card' => '1'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'A<B',
                    'type' => 'integer',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
