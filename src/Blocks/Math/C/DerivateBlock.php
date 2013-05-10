<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\DerivateBlock as Base;
use Rhoban\Blocks\VariableType;

class DerivateBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $lastValue = $this->getVariableIdentifier('lastValue', VariableType::Scalar, true);

        $code = "$lastValue = 0;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $derivate = $this->getOutputIdentifier('Derivate');
        $signal = $this->getInputIdentifier('Signal')->get($derivate->getType());
        $lastValue = $this->getVariableIdentifier('lastValue', VariableType::Scalar, true);
        $discount = $this->getParameterIdentifier('Discount')->get($derivate->getType());

        $code = "$derivate = ($signal-$lastValue)/".$this->environment->getPeriod().";\n";
        $code .= "$lastValue = ($discount*$lastValue)+(1-$discount)*($signal);\n";

        return $code;
    }
}
