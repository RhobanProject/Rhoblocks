<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\EqualBlock as Base;

class EqualBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $this->environment->addHeader('math.h');
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('A=B');
        $delta = $this->getParameterIdentifier('Delta')->get($output->getType());
        $A = $this->getInputIdentifier('A')->get($output->getType());
        $B = $this->getInputIdentifier('B')->get($output->getType());

        if ($delta == '0') {
            $code = "$output = ($A == $B);\n";
        } else {
            $code = "$output = (abs($A-$B) <= $delta);\n";
        }

        return $code;
    }
}
