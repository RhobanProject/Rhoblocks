<?php

namespace Rhoban\Blocks\Blocks\Signal\C;

use Rhoban\Blocks\Blocks\Signal\Meta\SquareBlock as Base;
use Rhoban\Blocks\VariableType;

class SquareBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $counter = $this->getVariableIdentifier('counter', VariableType::Integer, true);

        return $counter->lValue() ." = 0;\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $type = $this->getWeakestType();
        $output = $this->getOutputIdentifier('Square');
        $counter = $this->getVariableIdentifier('counter', VariableType::Integer, true);
        $duty = $this->getParameterIdentifier('Duty')->get($type);
        $frequency = $this->getParameterIdentifier('Frequency')->get($type);
        $machineFrequency = $this->environment->getFrequency();

        $ticksPerCycle = "($machineFrequency/$frequency)";
        $dutyTicks = "(($machineFrequency*$duty)/($frequency*100))";

        $code = $output . " = (".$counter." < $dutyTicks);\n";
        $code .= "$counter++;\n";
        $code .= "if ($counter >= $ticksPerCycle) {\n";
        $code .= "$counter = 0;\n";
        $code .= "}\n";

        return $code;
    }
}
