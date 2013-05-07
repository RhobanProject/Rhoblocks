<?php

namespace Rhoban\Blocks\Implementation\Arduino\IO;

use Rhoban\Blocks\Implementation\C\IO\PrintBlock as Base;

class PrintBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $this->environment->setOption('supportPrintf', true);

        return parent::implementInitCode();
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getInputSize('Value #');

        $values = array();
        $parts = preg_split('#(%[dgf])#', $this->getParameterIdentifier('Format'), -1, PREG_SPLIT_DELIM_CAPTURE);
        $trigger = $this->getInputIdentifier('Trigger')->asInteger();

        $pos = 0;
        $code = "if ($trigger) {\n";
        foreach ($parts as $part) {
            if ($part == '%d') {
                $code .= "Serial.print(".$this->getInputIdentifier(array('Value #', $pos++))->asInteger().");\n";
            } elseif ($part == '%f' || $part == '%g') {
                $code .= "Serial.print(".$this->getInputIdentifier(array('Value #', $pos++))->asScalar().");\n";
            } else {
                if ($part != '') {
                    $code .= "Serial.print(\"$part\");\n";
                }
            }
        }
        $code .= "Serial.println();\n";
        $code .= "}\n";

        return $code;
    }
}
