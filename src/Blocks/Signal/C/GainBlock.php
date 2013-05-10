<?php

namespace Rhoban\Blocks\Blocks\Signal\C;

use Rhoban\Blocks\Blocks\Signal\Meta\GainBlock as Base;

class GainBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $gain = $this->getParameterIdentifier('Gain')->get($output->getType());

        $code = "$output = $gain*$input;\n";

        return $code;
    }
}
