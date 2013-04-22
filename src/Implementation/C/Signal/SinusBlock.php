<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\SinusBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class SinusBlock extends Base
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
        $code = '';

        if ($this->getInputCardinality('T') == 0) {
            $T = $this->getVariableIdentifier('T', VariableType::Integer, true);
        } else {
            $T = $this->getInputIdentifier('T');
        }

        $code .= $this->getOutputLIdentifier('Wave');
        $code .= ' = sin(';
        $code .= $T;
        $code .= '*2.0*M_PI*';
        $code .= $this->getParameterIdentifier('Frequency');
        $code .= '+' . $this->getParameterIdentifier('Phase');
        $code .= ')*';
        $code .= $this->getParameterIdentifier('Amplitude');
        $code .= ";\n";
        
        if ($this->getInputCardinality('T') == 0) {
            $code .= "$T += ".$this->environment->getPeriod().";\n";
        }

        return $code;
    }
}
