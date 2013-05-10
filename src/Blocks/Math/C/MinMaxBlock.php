<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\MinMaxBlock as Base;

class MinMaxBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $min = $this->getParameterIdentifier('Min')->get($output->getType());
        $max = $this->getParameterIdentifier('Max')->get($output->getType());
        $input = $this->getInputIdentifier('Input')->get($output->getType());

        $code = "$output = $input;\n";
        $code .= "if ($output > $max) {\n";
        $code .= "$output = $max;\n";
        $code .= "}\n";
        $code .= "if ($output < $min) {\n";
        $code .= "$output = $min;\n";
        $code .= "}\n";

        return $code;
    }
}
