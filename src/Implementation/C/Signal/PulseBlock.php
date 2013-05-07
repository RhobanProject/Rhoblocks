<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\PulseBlock as Base;
use Rhoban\Blocks\VariableType;

class PulseBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $divider = $this->getVariableIdentifier('divider', VariableType::Integer, true);

        return $divider->lValue() ." = 0;\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Pulse');
        $divider = $this->getVariableIdentifier('divider', VariableType::Integer, true);
        $frequency = $this->environment->getFrequency();

        $code = $output . " = (".$divider."==0);\n";
        $code .= "$divider++;\n";
        $code .= "if ($divider >= ($frequency/".$this->getParameterIdentifier('Frequency').")) {\n";
        $code .= $divider . " = 0;\n";
        $code .= "}\n";

        return $code;
    }
}
