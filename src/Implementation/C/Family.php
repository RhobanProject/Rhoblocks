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
        $types = array(
            'Time.Chrono', 'Time.Delay',
            'Signal.Constant', 'Signal.Pulse', 'Signal.EdgeDetector',
            'IO.Output', 'IO.Print',
            'Math.Sinus', 'Math.Smaller', 'Math.Expression', 'Math.VariationBound', 'Math.Discount',
            'Logic.Counter', 'Logic.Memory'
        );
        $blocks = array();

        foreach ($types as $type) {
            list($family, $name) = explode('.', $type);
            $blocks[$name] = 'Rhoban\\Blocks\\Implementation\\C\\' . $family . '\\' . $name . 'Block';
        }

        return $blocks;
    }
}
