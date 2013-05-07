<?php

namespace Rhoban\Blocks\Implementation\C\IO;

use Rhoban\Blocks\Blocks\IO\OutputBlock as Base;
use Rhoban\Blocks\VariableType;

class OutputBlock extends Base
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
