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
        $output = $this->getOutputIdentifier('Value');

        return $output->lValue() . ' = ' . $this->getParameterIdentifier('Value')->get($output->getType()) . ";\n";
    }
}
