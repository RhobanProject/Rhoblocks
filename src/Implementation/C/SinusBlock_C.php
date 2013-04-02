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
    public function implementTransitionCode(
        array $parameters, 
        array $inputs, 
        EnvironmentInterface $environment)
    {
        $environment->registerState(
            $this->getId(), 
            0, 
            VariableType::Scalar);
        $code = '    ';
        $code .= $environment->stateName($this->getId(), 0);
        $code .= ' = ';
        $code .= 'sin(';
        $code .= $inputs['T'][0]['identifier'];
        $code .= '*2.0*3.14*';
        $code .= $parameters['Frequency'][0]['identifier'];
        $code .= '+';
        $code .= $parameters['Phase'][0]['identifier'];
        $code .= ')*';
        $code .= $parameters['Amplitude'][0]['identifier'];
        $code .= ";\n";

        return $code;
    }
}
