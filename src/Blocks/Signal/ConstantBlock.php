<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class ConstantBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Constant',
            'family' => 'Signal',
            'description' => 'A simple input constant',
            'size' => 'small',
            'parameters' => array(
                array(
                    'name' => 'Values',
                    'hide' => true,
                    'type' => array(
                        array(
                            'name' => 'Value',
                            'default' => array(1),
                            'card' => 0
                        ),
                    )
                )
            ),
            'inputs' => array(),
            'outputs' => array(
                array(
                    'name' => 'Value #',
                    'dynamicLabel' => 'self.parameters["Values.Value"][x]',
                    'length' => 'Values.length',
                    'card' => '0-*',
                ),
            ),
        );
    }
}
