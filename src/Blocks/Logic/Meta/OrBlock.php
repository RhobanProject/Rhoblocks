<?php

namespace Rhoban\Blocks\Blocks\Logic\Meta;

use Rhoban\Blocks\Block;

abstract class OrBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Or',
            'family' => 'Logic',
            'description' => 'Output logic OR of all the terms',
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
                    'name' => 'Or',
                    'type' => 'integer'
                ),
            ),
        );
    }
}
