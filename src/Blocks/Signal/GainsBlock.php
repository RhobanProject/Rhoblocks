<?php

namespace Rhoban\Blocks\Blocks\Signal;

use Rhoban\Blocks\Block;

abstract class GainsBlock extends Block
{
    /**
     * @see inherit
     */
    protected static function meta()
    {
        return array(
            'name' => 'Gains',
            'family' => 'Signal',
            'description' => 'Output n is input n * gain[n]',
            'parameters' => array(
                array(
                    'name' => 'Gains',
                    'type' => array(
                        array(
                            'name' => 'Gain',
                            'default' => array(1)
                        )
                    ),
                    'hide' => true,
                    'card' => 0
                ),
            ),
            'inputs' => array(
                array(
                    'name' => 'X#',
                    'card' => '0-1',
                    'length' => 'Gains.length'
                )
            ),
            'outputs' => array(
                array(
                    'name' => 'Output #',
                    'variadicLabel' => 'self.parameters["Gains.Gain"][x]+"*X"+(x+1)',
                    'card' => '0-*',
                    'length' => 'Gains.length'
                ),
            ),
        );
    }
}
