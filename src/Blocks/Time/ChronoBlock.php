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
            'parameters' => array(),
            'inputs' => array(),
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
