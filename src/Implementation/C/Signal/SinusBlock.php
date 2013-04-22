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
        $this->environment->addHeader('math.h');
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $code = '';

        if ($this->getInputCardinality('T') == 0) {
            $T = '('.$this->environment->getTicksIdentifier().'*'.$this->environment->getPeriod().')';
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

        return $code;
    }
}
