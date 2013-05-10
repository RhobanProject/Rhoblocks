<?php

namespace Rhoban\Blocks\Blocks\IO\Meta;

use Rhoban\Blocks\Block;

abstract class PrintBlock extends Block
{
    /**
     * @see inherit
     */
    public static function meta()
    {
        return array(
            'name' => 'Print',
            'family' => 'I/O',
            'description' => 'Print all the inputs',
            'parameters' => array(
                array(
                    'name' => 'Format',
                    'type' => 'textarea',
                    'default' => 'Value: %d',
                    'card' => 0
                ),
                array(
                    'name' => 'Inputs',
                    'hide' => true,
                    'type' => 'integer',
                    'default' => 1,
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
                    'name' => 'Value #',
                    'card' => '0-1',
                    'length' => 'Inputs.value'
                ),
            ),
            'outputs' => array(),
        );
    }
}
