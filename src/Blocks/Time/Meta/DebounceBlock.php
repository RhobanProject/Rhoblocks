<?php

namespace Rhoban\Blocks\Blocks\Time\Meta;

use Rhoban\Blocks\Block;

abstract class DebounceBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Debounce',
            'family' => 'Time',
            'description' => 'The input can\'t chance quicker than time',
            'parameters' => array(
                array(
                    'name' => 'Time',
                    'type' => 'number',
                    'unit' => 's',
                    'default' => 1
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Input',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Output',
                    'card' => '0-*'
                ),
            ),
        );
    }
}
