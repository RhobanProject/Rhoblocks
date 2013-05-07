<?php

namespace Rhoban\Blocks\Implementation\Arduino;

use Rhoban\Blocks\Implementation\C\Family as Base;

/**
 * The Arduino family
 */
class Family extends Base
{
    protected function getBlocks()
    {
        $types = array(
            'Pins.DigitalOutput',
            'Pins.DigitalInput',
            'Pins.PWMOutput',
            'Pins.AnalogInput',
            'IO.Print',
        );

        $blocks = parent::getBlocks();

        foreach ($types as $type) {
            list($family, $name) = explode('.', $type);
            $blocks[$name] = 'Rhoban\\Blocks\\Implementation\\Arduino\\' . $family . '\\' . $name . 'Block';
        }

        return $blocks;
    }
}
