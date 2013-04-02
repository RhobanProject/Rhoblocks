<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\ChronoBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class ChronoBlock_C extends ChronoBlock
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);

        return "$t = 0.0;\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $t = $this->getVariableIdentifier('T', VariableType::Scalar, true);

        $code = '$t += '.(1/$this->environment->getFrequency()).";\n";
        $code .= $this->getOutputLIdentifier('T') . ' = ' . $t . ";\n";

        return $code;
    }
}
