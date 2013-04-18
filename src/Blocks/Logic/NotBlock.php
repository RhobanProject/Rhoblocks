<?php

namespace Rhoban\Blocks\Blocks\Logic;

use Rhoban\Blocks\Block;

abstract class NotBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Not',
            'family' => 'Logic',
            'description' => 'Output logic NOT of all the terms',
            'parameters' => array(),
            'inputs' => array(
                array(
                    'name' => 'A',
                    'type' => 'integer',
                    'card' => '0-1',
                    'default' => 1
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Not A',
                    'type' => 'integer'
                ),
            ),
        );
    }
}
