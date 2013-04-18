<?php

namespace Rhoban\Blocks\Implementation\Arduino\Pins;

use Rhoban\Blocks\Blocks\Pins\PWMOutputBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class PWMOutputBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $pin = $this->getParameterIdentifier('Pin');
        $code = "pinMode($pin, OUTPUT);\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $pin = $this->getParameterIdentifier('Pin');
        $level = $this->getInputIdentifier('Level')->asInteger();

        $code = "analogWrite($pin, $level);\n";

        return $code;
    }
}
