<?php

namespace Rhoban\Blocks\Blocks\Pins\Arduino;

use Rhoban\Blocks\Blocks\Pins\Meta\PWMOutputBlock as Base;

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
