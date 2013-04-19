<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\SumBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class SumBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $identifiers = $this->getInputIdentifiers('Terms');
        $output = $this->getOutputIdentifier('Sum');

        $code = "$output = 0;\n";

        foreach ($identifiers as $identifier) {
            $input = $identifier->get($output->getType());
            $code .= "$output += $input;\n";
        }

        return $code;
    }
}
