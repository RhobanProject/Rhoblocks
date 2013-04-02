<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\ConstantBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ConstantBlock_C extends ConstantBlock
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        return $this->getOutputIdentifier('Value') . ' = ' . $this->getParameterIdentifier('Value') . ";\n";
    }
}
