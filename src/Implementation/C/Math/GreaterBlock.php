<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\GreaterBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class GreaterBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $weakest = $this->getWeakestType();

        $code = $this->getOutputLIdentifier('A>B');
        $code .= ' = ';
        $code .= $this->getInputIdentifier('A')->get($weakest);
        $code .= ' > ';
        $code .= $this->getInputIdentifier('B')->get($weakest);
        $code .= ";\n";

        return $code;
    }
}
