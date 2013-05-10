<?php

namespace Rhoban\Blocks\Blocks\Signal\C;

use Rhoban\Blocks\Blocks\Signal\Meta\GainsBlock as Base;

class GainsBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $size = $this->getOutputSize('Output #');

        if ($size != $this->getInputSize('X#')) {
            throw new \RuntimeException('Input size should equals output');
        }

        if ($size != $this->getParameterVariadicSize('Gains', 'Gain')) {
            throw new \RuntimeException('Input size should equals variadic parameters');
        }

        $code = '';

        for ($i=0; $i<$size; $i++) {
            $output = $this->getOutputIdentifier(array('Output #', $i));
            $input = $this->getInputIdentifier(array('X#', $i))->get($output->getType());
            $gain = $this->getParameterVariadicIdentifier('Gains', 'Gain', $i)->get($output->getType());
            $code .= "$output = $gain*$input;\n";
        }

        return $code;
    }
}
