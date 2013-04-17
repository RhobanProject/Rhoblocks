<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\ChronoBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ChronoBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);

        return "$t = -".(1/$this->environment->getFrequency()).";\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);

        $code = $t .' += '.(1/$this->environment->getFrequency()).";\n";
        $code .= $this->getOutputLIdentifier('T') . ' = ' . $t . ";\n";

        return $code;
    }
}
