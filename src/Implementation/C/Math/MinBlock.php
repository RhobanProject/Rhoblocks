<?php

namespace Rhoban\Blocks\Implementation\C\Math;

use Rhoban\Blocks\Blocks\Math\MinBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class MinBlock extends Base
{
    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $identifiers = $this->getInputIdentifiers('Terms');
        $output = $this->getOutputIdentifier('Min');

        if (!count($identifiers)) {
            $code = "$output = 0;\n";
        } else {
            $first = true;

            foreach ($identifiers as $identifier) {
                $input = $identifier->get($output->getType());

                if ($first) {
                    $first = false;
                    $code = "$output = $input;\n";
                } else {
                    $code .= "if ($input < $output) {\n";
                    $code .= "$output = $input;\n";
                    $code .= "}\n";
                }
            }
        }

        return $code;
    }
}
