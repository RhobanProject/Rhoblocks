<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\TriangleBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class TriangleBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $code = '';

        if ($this->getInputCardinality('T') == 0) {
            $T = $this->getVariableIdentifier('T', VariableType::Scalar, true);
            $code = "$T = 0;\n";
        }

        $this->environment->addHeader('math.h');

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $x = $this->getVariableIdentifier('X', VariableType::Scalar);
        $frequency = $this->getParameterIdentifier('Frequency');
        $phase = $this->getParameterIdentifier('Phase');
        $wave = $this->getOutputLIdentifier('Wave');
        $amplitude = $this->getParameterIdentifier('Amplitude');

        $code = '';

        if ($this->getInputCardinality('T') == 0) {
            $T = $this->getVariableIdentifier('T', VariableType::Integer, true);
        } else {
            $T = $this->getInputIdentifier('T');
        }

        // Putting X between 0 and 1
        $code .= "$x = $T*$frequency+$phase;\n";
        $code .= "$x -= (integer)($x);\n";
        $code .= "if ($x < 0) {\n";
        $code .= "$x += 1;\n";
        $code .= "}\n";

        // Calculating the square
        $code .= "$wave = $amplitude*(($x<0.5) ? (2*$x) : (2-2*$x));\n";

        // Increasing timer
        if ($this->getInputCardinality('T') == 0) {
            $code .= "$T += ".$this->environment->getPeriod().";\n";
        }

        return $code;
    }
}
