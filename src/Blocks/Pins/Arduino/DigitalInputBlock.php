<?php

namespace Rhoban\Blocks\Blocks\Pins\Arduino;

use Rhoban\Blocks\Blocks\Pins\Meta\DigitalInputBlock as Base;

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
