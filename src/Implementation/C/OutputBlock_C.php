<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\OutputBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class OutputBlock_C extends OutputBlock
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $o = $this->getGlobalOutputIdentifier($this->getParameterIdentifier('Index')->asInteger(), VariableType::Scalar);

        return "$o = 0.0;\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $o = $this->getGlobalOutputIdentifier($this->getParameterIdentifier('Index')->asInteger(), VariableType::Scalar);

        return "$o = ".$this->getInputIdentifier('Value').";\n";
    }
}
