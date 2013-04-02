<?php

namespace Rhoban\Blocks\Blocks;

use Rhoban\Blocks\Block;

abstract class ChronoBlock extends Block
{
    /**
     * @see inherit
     */
    protected static $META = array(
        'name' => 'Chrono',
        'family' => 'Time',
        'description' => 'Outputs the time',
        'parameters' => array(),
        'inputs' => array(),
        'outputs' => array(
            array(
                'name' => 'T',
                'card' => '0-*',
            ),
        ),
    );
}
