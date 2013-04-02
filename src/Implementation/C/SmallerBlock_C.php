<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\SmallerBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class SmallerBlock_C extends SmallerBlock
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $code = $this->getOutputIdentifier('A<B')->asInteger();
        $code .= ' = ';
        $code .= $this->getInputIdentifier('A');
        $code .= ' < ';
        $code .= $this->getInputIdentifier('B');
        $code .= ";\n";

        return $code;
    }
}
