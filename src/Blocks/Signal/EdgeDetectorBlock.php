<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class EdgeDetectorBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'EdgeDetector',
            'family' => 'Signal',
            'description' => 'Detects the edges',
            'parameters' => array(
                array(
                    'name' => 'Rising',
                    'default' => true,
                    'type' => 'check'
                ),
                array(
                    'name' => 'Falling',
                    'default' => false,
                    'type' => 'check'
                )
            ),
            'inputs' => array(
                array(
                    'name' => 'Signal',
                    'card' => '0-1',
                    'type' => 'integer'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Pulse',
                    'card' => '0-*',
                    'type' => 'integer'
                )
            ),
        );
    }
}
