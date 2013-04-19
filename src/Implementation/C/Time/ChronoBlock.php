<?php

namespace Rhoban\Blocks\Implementation\C\Time;

use Rhoban\Blocks\Blocks\Time\ChronoBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ChronoBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);

        return "$t = -".(1/$this->environment->getFrequency()).";\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);
        $reset = $this->getInputIdentifier('Reset')->asInteger();
        $factor = $this->getParameterIdentifier('Factor');

        $code = "if ($reset) {\n";
        $code .= "$t = 0;\n";
        $code .= "} else {\n";
        $code .= $t .' += ('.$this->environment->getPeriod().")*$factor;\n";
        $code .= "}\n";
        $code .= $this->getOutputLIdentifier('T') . ' = ' . $t . ";\n";

        return $code;
    }
}
