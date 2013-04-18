<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\ExpressionBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ExpressionBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $this->environment->addHeader('math.h');
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getInputSize('X#');
        $expression = ''.$this->getParameterIdentifier('Expression');
        $output = $this->getOutputIdentifier('Result');

        for ($i=0; $i<$size; $i++) {
            $expression = str_replace('X'.($i+1), $this->getInputIdentifier(array('X#', $i))->get($output->getType()), $expression);
        }

        $code = "$output = ($expression);\n";

        return $code;
    }
}
