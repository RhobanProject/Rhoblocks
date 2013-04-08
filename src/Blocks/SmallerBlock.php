<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class SmallerBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
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
