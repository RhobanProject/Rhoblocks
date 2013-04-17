<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\DelayBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class DelayBlock extends Base
{
    protected $size;

    protected function guessOutputType($name)
    {
        $input = $this->getInputIdentifier('Input');

        return $input->getType();
    }

    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $delay = $this->getParameterIdentifier('Delay')->getValue();
        $frequency = $this->environment->getFrequency();
        $this->size = (int)($delay*$frequency);

        $output = $this->getOutputIdentifier('Output');
        $default = $this->getParameterIdentifier('Default');
        $values = $this->getVariableIdentifier('values', $output->getType(), true, $this->size);
        $position = $this->getVariableIdentifier('position', VariableType::Integer, true);

        $code = "for (i=0; i<".$this->size."; i++) {\n";
        $code .= '    '.$values."[i] = ".$default.";\n";
        $code .= "}\n";
        $code .= "$position = 0;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $position = $this->getVariableIdentifier('position', VariableType::Integer, true);
        $output = $this->getOutputIdentifier('Output');
        $input = $this->getInputIdentifier('Input');
        $values = $this->getVariableIdentifier('values', $output->getType(), true, $this->size);

        $code =  $values . '[' . $position . "] = ".$input.";\n";
        $code .= $position . "= (".$position."+1)%".$this->size.";\n";
        $code .= $output . ' = ' . $values . '[' . $position . "];\n";

        return $code;
    }
}
