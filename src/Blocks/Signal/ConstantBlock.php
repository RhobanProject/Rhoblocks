<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class ConstantBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Constant',
            'family' => 'Signal',
            'description' => 'A simple input constant',
            'parameters' => array(
                array(
                    'name' => 'Value',
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
}
