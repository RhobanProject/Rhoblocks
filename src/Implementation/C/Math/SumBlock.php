<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\SumBlock as Base;

class SumBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getInputSize('Term #');
        $output = $this->getOutputIdentifier('Sum');

        $code = "$output = 0;\n";

        for ($i=0; $i<$size; $i++) {
            $input = $this->getInputIdentifier(array('Term #', $i));
            $code .= "$output += $input;\n";
        }

        return $code;
    }
}
