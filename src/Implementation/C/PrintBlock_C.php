<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Blocks\PrintBlock;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class PrintBlock_C extends PrintBlock
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $this->environment->addHeader('stdio.h');
        $divider = $this->getVariableIdentifier('divider', VariableType::Integer, true);

        return $divider->lValue() ." = 0;\n";
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $divider = $this->getVariableIdentifier('divider', VariableType::Integer, true);
        $size = $this->getInputSize('Value #');
        $frequency = $this->environment->getFrequency();

        $values = array();
        preg_match_all('#%([dgf])#', $this->getParameterIdentifier('Format'), $matches);

        for ($i=0; $i<$size; $i++) {
            $identifier = $this->getInputIdentifier(array('Value #', $i));

            if (isset($matches[1][$i])) {
                if ($matches[1][$i] == 'd') {
                    $values[] = $identifier->get(VariableType::Integer);
                } else {
                    $values[] = $identifier->get(VariableType::Scalar);
                }
            } else {
                $values[] = $identifier->lValue();
            }
        }

        $code = "if ($divider == 0) {\n";
        $code .= "printf(\"".$this->getParameterIdentifier('Format')."\\n\", ".implode(', ', $values).");\n";
        $code .= "}\n";

        $code .= $divider->lValue() . "++;\n";
        $code .= "if ($divider > ($frequency/".$this->getParameterIdentifier('Frequency').")) {\n";
        $code .= $divider->lValue() . " = 0;\n";
        $code .= "}\n";

        return $code;
    }
}
