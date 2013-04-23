<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\ConstantBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ConstantBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getOutputSize('Value #');
        $code = '';

        for ($i=0; $i<$size; $i++) {
            $output = $this->getOutputIdentifier(array('Value #', $i));
            $code .= "$output = ".$this->getParameterVariadicIdentifier('Values', 'Value', $i)->get($output->getType()).";\n";
        }

        return $code;
    }
}
