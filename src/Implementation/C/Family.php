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
            'Signal.Constant', 'Signal.Pulse', 'Signal.EdgeDetector', 'Signal.Square', 'Signal.Gain', 'Signal.Multiplexer', 'Signal.Demultiplexer',
            'IO.Output', 'IO.Print',
            'Math.Sinus', 'Math.Smaller', 'Math.Expression', 'Math.VariationBound', 
            'Math.Discount', 'Math.Greater', 'Math.PID', 'Math.MinMax',
            'Math.DerivativeDriver', 'Math.Min', 'Math.Max', 'Math.Sum', 'Math.Equal', 'Math.Derivate',
            'Logic.Counter', 'Logic.Memory', 'Logic.And', 'Logic.Or', 'Logic.Not', 'Logic.Xor',
            'Loop.Loop'
        );
        $blocks = array();

        foreach ($types as $type) {
            list($family, $name) = explode('.', $type);
            $blocks[$name] = 'Rhoban\\Blocks\\Implementation\\C\\' . $family . '\\' . $name . 'Block';
        }

        return $blocks;
    }
}
