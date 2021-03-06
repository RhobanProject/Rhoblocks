<?php

namespace Rhoban\Blocks\Blocks\Logic\Meta;

use Rhoban\Blocks\Block;

abstract class CounterBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Counter',
            'family' => 'Logic',
            'description' => 'Counts until max on each trigger',
            'parameters' => array(
                array(
                    'name' => 'Default',
                    'type' => 'integer',
                    'card' => 0,
                    'default' => 0
                ),
                array(
                    'name' => 'Max',
                    'type' => 'integer',
                    'default' => 1
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Trigger',
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Value',
                    'type' => 'integer'
                ),
            ),
        );
    }
}
