<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\DiscountBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class DiscountBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $hasValue = $this->getVariableIdentifier('hasValue', VariableType::Integer, true);
        $code = "$hasValue = 0;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $hasValue = $this->getVariableIdentifier('hasValue', VariableType::Integer, true);
        $value = $this->getVariableIdentifier('value', $output->getType(), true);
        $discount = $this->getParameterIdentifier('Factor')->get($output->getType());

        $code = "if (!$hasValue) {\n";
        $code .= "$hasValue = 1;\n";
        $code .= "$value = $input;\n";
        $code .= "} else {\n";
        $code .= "$value = ((1-$discount)*$input)+(($discount)*$value);\n";
        $code .= "}\n";
        $code .= "$output = $value;\n";

        return $code;
    }
}
