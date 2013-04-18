<?php

namespace Rhoban\Blocks\Implementation\Arduino\Pins;

use Rhoban\Blocks\Blocks\Pins\DigitalInputBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class DigitalInputBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $pin = $this->getParameterIdentifier('Pin');
        $pullup = $this->getParameterIdentifier('Pull-Up');

        if ($pullup) {
            $code = "pinMode($pin, INPUT_PULLUP);\n";
        } else {
            $code = "pinMode($pin, INPUT);\n";
        }

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $pin = $this->getParameterIdentifier('Pin');
        $output = $this->getOutputIdentifier('Level');
        $invert = $this->getParameterIdentifier('Invert')->asInteger();

        $code = "$output = digitalRead($pin);\n";
        $code .= "if ($invert) {\n";
        $code .= "$output = !$output;\n";
        $code .= "}\n";

        return $code;
    }
}
