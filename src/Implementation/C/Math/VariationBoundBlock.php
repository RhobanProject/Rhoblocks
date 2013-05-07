<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\VariationBoundBlock as Base;
use Rhoban\Blocks\VariableType;

class VariationBoundBlock extends Base
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
        $delta = $this->getVariableIdentifier('delta', $output->getType());
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $hasValue = $this->getVariableIdentifier('hasValue', VariableType::Integer, true);
        $value = $this->getVariableIdentifier('value', $output->getType(), true);
        $limit = $this->getParameterIdentifier('Limit')->get($output->getType());

        $tickLimit = "($limit/".$this->environment->getFrequency().')';

        $code = "if (!$hasValue) {\n";
        $code .= "$hasValue = 1;\n";
        $code .= "$value = $input;\n";
        $code .= "} else {\n";
        $code .= "$delta = ($input-$value);\n";
        $code .= "if ($delta > $tickLimit) {\n";
        $code .= "$delta = $tickLimit;\n";
        $code .= "}\n";
        $code .= "if ($delta < -$tickLimit) {\n";
        $code .= "$delta = -$tickLimit;\n";
        $code .= "}\n";
        $code .= "$value += $delta;\n";
        $code .= "}\n";
        $code .= "$output = $value;\n";

        return $code;
    }
}
