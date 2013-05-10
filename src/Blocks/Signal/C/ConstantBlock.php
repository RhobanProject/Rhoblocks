<?php

namespace Rhoban\Blocks\Blocks\Signal\C;

use Rhoban\Blocks\Blocks\Signal\Meta\ConstantBlock as Base;

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
