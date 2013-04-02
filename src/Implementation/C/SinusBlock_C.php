<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\SinusBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class SinusBlock_C extends SinusBlock
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {

        $code = $this->getOutputIdentifier('Wave');
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
