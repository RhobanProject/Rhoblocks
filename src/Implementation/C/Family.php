<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Family as Base;

/**
 * The C family
 */
class Family extends Base
{
    protected function getBlocks()
    {
        $types = array('Chrono', 'Constant', 'Delay', 'Output', 
            'Print', 'Pulse', 'Sinus', 'Smaller');
        $blocks = array();

        foreach ($types as $type) {
            $blocks[$type] = 'Rhoban\\Blocks\\Implementation\\C\\' . $type . 'Block';
        }

        return $blocks;
    }
}
