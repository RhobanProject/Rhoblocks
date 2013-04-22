<?php

namespace Rhoban\Blocks\Implementation\C\Signal;

use Rhoban\Blocks\Blocks\Signal\DemultiplexerBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class DemultiplexerBlock extends Base
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
        $type = $this->getWeakestType();
        $size = $this->getOutputSize('Output #');
        $case = $this->getVariableIdentifier('currentCase', VariableType::Integer);
        $cyclic = $this->getParameterIdentifier('Cyclic')->asInteger();
        $N = $this->getInputIdentifier('N')->asInteger();
        $fallback = $this->getParameterIdentifier('FallbackValue')->get($type);
        $value = $this->getParameterIdentifier('Value')->get($type);

        $code = "$case = $N;\n";
        $code .= "if ($cyclic) {\n";
        $code .= "$case %= $size;\n";
        $code .= "}\n";

        for ($i=0; $i<$size; $i++) {
            $output = $this->getOutputIdentifier(array('Output #', $i));
            $code .= "$output = ($case == $i) ? $value : $fallback;\n";
        }

        return $code;
    }
}
