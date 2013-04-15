<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\MultiplexerBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class MultiplexerBlock_C extends MultiplexerBlock
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
        $case = $this->getVariableIdentifier('currentCase', VariableType::Integer);
        $size = $this->getInputSize('Input #');
        $output = $this->getOutputIdentifier('Output');
        $type = $output->getType();
        $output = $output->lValue();

        $code = '';

        $code .= $case->lValue() ." = ".$this->getInputIdentifier('N')->asInteger().";\n";
        $code .= "if (".$this->getParameterIdentifier('Cyclic')->asInteger().") {\n";
        $code .= $case->lValue() ." %= $size;\n";
        $code .= "};\n";

        $code .= 'switch ('.$case->asInteger().") {\n";
        for ($i=0; $i<$size; $i++) {
            $code .= "    case $i:\n";
            $code .= "        $output = ".$this->getInputIdentifier(array('Input #', $i))->get($type).";\n";
            $code .= "    break;\n";
        }
        $code .= "    default:\n";
        $code .= "        $output = ".$this->getParameterIdentifier('FallbackValue')->get($type).";\n";
        $code .= "};\n";

        return $code;
    }
}
