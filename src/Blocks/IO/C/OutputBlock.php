<?php

namespace Rhoban\Blocks\Blocks\IO\C;

use Rhoban\Blocks\Blocks\IO\Meta\OutputBlock as Base;
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
