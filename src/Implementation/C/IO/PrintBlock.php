<?php

namespace Rhoban\Blocks\Implementation\C\IO;

use Rhoban\Blocks\Blocks\IO\PrintBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class PrintBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $this->environment->addHeader('stdio.h');
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
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

        $trigger = $this->getInputIdentifier('Trigger')->asInteger();

        $code = "if ($trigger) {\n";
        $comma = '';
        if ($size) {
            $comma = ',';
        }
        $code .= "printf(\"".$this->getParameterIdentifier('Format')."\\n\"$comma ".implode(', ', $values).");\n";
        $code .= "fflush(stdout);\n";
        $code .= "}\n";

        return $code;
    }
}
