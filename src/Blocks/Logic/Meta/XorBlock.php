<?php

namespace Rhoban\Blocks\Blocks\Logic\Meta;

use Rhoban\Blocks\Block;

abstract class XorBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Xor',
            'family' => 'Logic',
            'description' => 'Output logic XOR of all the terms',
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
                    'name' => 'Xor',
                    'type' => 'integer'
                ),
            ),
        );
    }
}
