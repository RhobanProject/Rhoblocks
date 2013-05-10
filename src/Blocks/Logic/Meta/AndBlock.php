<?php

namespace Rhoban\Blocks\Blocks\Logic\Meta;

use Rhoban\Blocks\Block;

abstract class AndBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'And',
            'family' => 'Logic',
            'description' => 'Output logic AND of all the terms',
            'parameters' => array(),
            'inputs' => array(
                array(
                    'name' => 'Terms',
                    'type' => 'integer',
                    'card' => '0-*'
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'And',
                    'type' => 'integer'
                ),
            ),
        );
    }
}
