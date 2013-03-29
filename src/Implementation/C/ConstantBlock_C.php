<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\ConstantBlock;
use Rhoban\Blocks\VariableHolderInterface;
use Rhoban\Blocks\VariableType;

class ConstantBlock_C extends ConstantBlock
{
    /**
     * @inherit
     */
    public function implementTransitionCode(
        array $parameters, 
        array $inputs, 
        VariableHolderInterface $variableHolder)
    {
        $variableHolder->registerState(
            $this->getId(), 
            0, 
            $parameters['Value'][0]['type']);
        $code = '    ';
        $code .= $variableHolder->stateName($this->getId(), 0);
        $code .= ' = ';
        $code .= $parameters['Value'][0]['identifier'];
        $code .= ";\n";

        return $code;
    }
}
