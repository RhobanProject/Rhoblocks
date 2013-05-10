<?php

namespace Rhoban\Blocks\Blocks\Time\C;

use Rhoban\Blocks\Blocks\Time\Meta\ChronoBlock as Base;
use Rhoban\Blocks\VariableType;

class ChronoBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);
        $default = $this->getParameterIdentifier('Default')->asScalar();

        return "$t = ".$default."-".(1/$this->environment->getFrequency()).";\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);
        $reset = $this->getInputIdentifier('Reset')->asInteger();
        $pause = $this->getInputIdentifier('Pause')->asInteger();
        $factor = $this->getParameterIdentifier('Factor');

        $code = "if ($reset) {\n";
        $code .= "$t = 0;\n";
        $code .= "} else {\n";
        $code .= "if (!$pause) {;\n";
        $code .= $t .' += ('.$this->environment->getPeriod().")*$factor;\n";
        $code .= "}\n";
        $code .= "}\n";
        $code .= $this->getOutputLIdentifier('T') . ' = ' . $t . ";\n";

        return $code;
    }
}
