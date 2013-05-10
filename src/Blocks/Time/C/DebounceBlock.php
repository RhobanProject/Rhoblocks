<?php

namespace Rhoban\Blocks\Blocks\Time\C;

use Rhoban\Blocks\Blocks\Time\Meta\DebounceBlock as Base;
use Rhoban\Blocks\VariableType;

class DebounceBlock extends Base
{
    protected function guessOutputType($name)
    {
        return $this->getInputIdentifier('Input')->getType();
    }

    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $lastUpdate = $this->getVariableIdentifier('lastUpdate', VariableType::Integer, true);

        $code = "$lastUpdate = -1;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $time = $this->getParameterIdentifier('Time');
        $value = $this->getVariableIdentifier('value', $output->getType(), true);
        $lastUpdate = $this->getVariableIdentifier('lastUpdate', VariableType::Integer, true);
        $ticks = $this->environment->getTicksIdentifier();
        $frequency = $this->environment->getFrequency();

        $code = "if (($lastUpdate<0 || ($lastUpdate+$time*$frequency) < $ticks) && ($value != $input)) {\n";
        $code .= "$lastUpdate = $ticks;\n";
        $code .= "$value = $input;\n";
        $code .= "}\n";
        $code .= "$output = $value;\n";

        return $code;
    }
}
