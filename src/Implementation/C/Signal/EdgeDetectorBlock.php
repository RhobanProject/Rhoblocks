<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\EdgeDetectorBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class EdgeDetectorBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $lastValue = $this->getVariableIdentifier('lastValue', VariableType::Integer, true);
        $code = "$lastValue = 0;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Pulse');
        $lastValue = $this->getVariableIdentifier('lastValue', VariableType::Integer, true);
        $input = $this->getInputIdentifier('Signal')->asInteger();
        $rising = $this->getParameterIdentifier('Rising')->asInteger();
        $falling = $this->getParameterIdentifier('Falling')->asInteger();

        $code = "$output = ($input < $lastValue && $falling) || ($input > $lastValue && $rising);\n";
        $code .= "$lastValue = $input;\n";

        return $code;
    }
}
