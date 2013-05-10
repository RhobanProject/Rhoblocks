<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\DerivativeDriverBlock as Base;

class DerivativeDriverBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $output = $this->getOutputIdentifier('Value');
        $value = $this->getVariableIdentifier('value', $output->getType(), true);
        $default = $this->getParameterIdentifier('Default')->get($output->getType());

        $code = "$value = $default;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Value');
        $derivate = $this->getInputIdentifier('Derivate')->get($output->getType());
        $value = $this->getVariableIdentifier('value', $output->getType(), true);
        $min = $this->getParameterIdentifier('Min')->get($output->getType());
        $max = $this->getParameterIdentifier('Max')->get($output->getType());

        $code = "$value += ($derivate*".$this->environment->getPeriod().");\n";
        $code .= "if ($value > $max) {\n";
        $code .= "$value = $max;\n";
        $code .= "}\n";
        $code .= "if ($value < $min) {\n";
        $code .= "$value = $min;\n";
        $code .= "}\n";
        $code .= "$output = $value;\n";

        return $code;
    }
}
