<?php

namespace Rhoban\Blocks\Implementation\Arduino\Pins;

use Rhoban\Blocks\Blocks\Pins\DigitalOutputBlock as Base;

class DigitalOutputBlock extends Base
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

        $code = "digitalWrite($pin, $level);\n";

        return $code;
    }
}
