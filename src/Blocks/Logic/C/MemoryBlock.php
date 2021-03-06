<?php

namespace Rhoban\Blocks\Blocks\Logic\C;

use Rhoban\Blocks\Blocks\Logic\Meta\MemoryBlock as Base;

class MemoryBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $output = $this->getOutputIdentifier('Memory');
        $memory = $this->getVariableIdentifier('memory', $output->getType(), true);
        $default = $this->getParameterIdentifier('Default')->get($output->getType());

        $code = "$memory = $default;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Memory');
        $memory = $this->getVariableIdentifier('memory', $output->getType(), true);
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $trigger = $this->getInputIdentifier('Trigger')->asInteger();

        $code = "if ($trigger) {\n";
        $code .= "$memory = $input;\n";
        $code .= "}\n";

        $code .= "$output = $memory;\n";

        return $code;
    }
}
