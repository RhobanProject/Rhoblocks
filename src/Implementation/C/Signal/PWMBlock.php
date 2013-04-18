<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\PWMBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class PWMBlock extends Base
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
        $output = $this->getOutputIdentifier('PWM');
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
