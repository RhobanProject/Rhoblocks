<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\MaxBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class MaxBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getInputSize('Term #');
        $output = $this->getOutputIdentifier('Max');

        if (!$size) {
            $code = "$output = 0;\n";
        } else {
            $first = true;

            for ($i=0; $i<$size; $i++) {
                $input = $this->getInputIdentifier(array('Term #', $i));

                if ($first) {
                    $first = false;
                    $code = "$output = $input;\n";
                } else {
                    $code .= "if ($input > $output) {\n";
                    $code .= "$output = $input;\n";
                    $code .= "}\n";
                }
            }
        }

        return $code;
    }
}
