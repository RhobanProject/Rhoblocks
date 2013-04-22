<?php

namespace Rhoban\Blocks\Blocks\Time;

use Rhoban\Blocks\Block;

abstract class ChronoBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Chrono',
            'family' => 'Time',
            'description' => 'Outputs the time',
            'parameters' => array(
                array(
                    'name' => 'Factor',
                    'type' => 'number',
                    'default' => 1
                ),
                array(
                    'name' => 'Default',
                    'type' => 'number',
                    'card' => 0,
                    'default' => 0
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'Pause',
                    'card' => '0-1',
                    'default' => 0
                ),
                array(
                    'name' => 'Reset',
                    'card' => '0-1',
                    'default' => 0
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'T',
                    'card' => '0-*',
                    'type' => 'number'
                ),
            ),
        );
    }
}
