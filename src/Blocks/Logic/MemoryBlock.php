<?php

namespace Rhoban\Blocks\Blocks\Logic;

use Rhoban\Blocks\Block;

abstract class MemoryBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Memory',
            'family' => 'Logic',
            'description' => 'The output is memorized input on trigger',
            'parameters' => array(
                array(
                    'name' => 'Default',
                    'default' => 0,
                    'card' => 0
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Trigger',
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 0
                ),
                array(
                    'name' => 'Input',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Memory',
                    'card' => '0-*'
                ),
            ),
        );
    }
}
