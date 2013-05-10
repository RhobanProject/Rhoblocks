<?php

namespace Rhoban\Blocks\Blocks\Signal\Meta;

use Rhoban\Blocks\Block;

abstract class SinusBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Sinus',
            'family' => 'Signal',
            'description' => 'Outputs <b>sin(T+phase)*amplitude</b>',
            'parameters' => array(
                array(
                    'name' => 'Amplitude',
                    'type' => 'number',
                    'default' => 1,
                ),
                array(
                    'name' => 'Frequency',
                    'type' => 'number',
                    'unit' => 'Hz',
                    'default' => 1,
                ),
                array(
                    'name' => 'Phase',
                    'type' => 'number',
                    'unit' => '°',
                    'default' => 0,
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'T',
                    'card' => '0-1',
                    'default' => 0
                ),
            ),
            'outputs' => array(
                array(
                    'name' => 'Wave',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
