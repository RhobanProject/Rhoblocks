<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class ConstantBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Constant',
        'family' => 'Math',
        'description' => 'A simple input constant',
        'parameters' => array(
            array(
                'name' => 'Value',
                'type' => 'number',
                'default' => 0,
            ),
        ),
        'inputs' => array(),
        'outputs' => array(
            array(
                'name' => 'Value',
                'card' => '0-*',
            ),
        ),
    );
}
