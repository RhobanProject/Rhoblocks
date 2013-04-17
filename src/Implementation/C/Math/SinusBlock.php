<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\SinusBlock as Base;
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
        $code = $this->getOutputLIdentifier('Wave');
        $code .= ' = sin(';
        $code .= $this->getInputIdentifier('T');
        $code .= '*2.0*M_PI*';
        $code .= $this->getParameterIdentifier('Frequency');
        $code .= '+' . $this->getParameterIdentifier('Phase');
        $code .= ')*';
        $code .= $this->getParameterIdentifier('Amplitude');
        $code .= ";\n";

        return $code;
    }
}
