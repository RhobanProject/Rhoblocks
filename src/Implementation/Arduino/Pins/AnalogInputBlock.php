<?php

namespace Rhoban\Blocks\Implementation\Arduino\Pins;

use Rhoban\Blocks\Blocks\Pins\AnalogInputBlock as Base;

class AnalogInputBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $pin = $this->getParameterIdentifier('Pin');

        $code = "pinMode($pin, INPUT);\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $pin = $this->getParameterIdentifier('Pin');
        $output = $this->getOutputIdentifier('Level');

        $code = "$output = analogRead($pin);\n";

        return $code;
    }
}
