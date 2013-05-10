<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\SmallerBlock as Base;

class SmallerBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $weakest = $this->getWeakestType();

        $code = $this->getOutputLIdentifier('A<B');
        $code .= ' = ';
        $code .= $this->getInputIdentifier('A')->get($weakest);
        $code .= ' < ';
        $code .= $this->getInputIdentifier('B')->get($weakest);
        $code .= ";\n";

        return $code;
    }
}
