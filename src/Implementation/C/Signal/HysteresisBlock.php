<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\HysteresisBlock as Base;
use Rhoban\Blocks\VariableType;

class HysteresisBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $currentValue = $this->getVariableIdentifier('currentValue', VariableType::Integer, true);
        $default = $this->getParameterIdentifier('Default')->asInteger();

        $code = "$currentValue = $default;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $currentValue = $this->getVariableIdentifier('currentValue', VariableType::Integer, true);
        $output = $this->getOutputIdentifier('Output');
        $type = $this->getWeakestType();
        $signal = $this->getInputIdentifier('Signal')->get($type);
        $min = $this->getParameterIdentifier('Min')->get($type);
        $max = $this->getParameterIdentifier('Max')->get($type);

        $code = '';
        $code .= "if ($signal <= $min) {\n";
        $code .= "$currentValue = 0;\n";
        $code .= "}\n";
        $code .= "if ($signal >= $max) {\n";
        $code .= "$currentValue = 1;\n";
        $code .= "}\n";
        $code .= "$output = $currentValue;\n";

        return $code;
    }
}
