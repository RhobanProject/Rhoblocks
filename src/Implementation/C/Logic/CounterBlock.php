<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\CounterBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class CounterBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $counter = $this->getVariableIdentifier('counter', VariableType::Integer, true);
        $default = $this->getParameterIdentifier('Default')->asInteger();

        $code = "$counter = ".$default.";\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $value = $this->getOutputIdentifier('Value');
        $counter = $this->getVariableIdentifier('counter', VariableType::Integer, true);
        $trigger = $this->getInputIdentifier('Trigger')->asInteger();
        $max = $this->getParameterIdentifier('Max')->asInteger();

        $code = "$value = $counter;\n";
        $code .= "if ($trigger) {\n";
        $code .= "$counter++;\n";
        $code .= "if ($counter > $max) {\n";
        $code .= "$counter = 0;\n";
        $code .= "}\n";
        $code .= "}\n";

        return $code;
    }
}
