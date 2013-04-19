<?php

namespace Rhoban\Blocks\Implementation\C\Loop;

use Rhoban\Blocks\Blocks\Loop\LoopBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class LoopBlock extends Base
{
    public function getOutputIdentifier($nameOrId, $id = false)
    {
        $type = $this->getWeakestType();
        return $this->getVariableIdentifier('loop', $type, true);
    }

    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $default = $this->getParameterIdentifier('Default')->get($output->getType());

        $code = "$output = $default;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $output = $this->getOutputIdentifier('Output');
        $input = $this->getInputIdentifier('Input')->get($output->getType());
        $code = "$output = $input;\n";

        return $code;
    }
}
