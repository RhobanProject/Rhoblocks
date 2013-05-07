<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\GainBlock as Base;

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
