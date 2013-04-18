<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\NotBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class NotBlock extends Base
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
        $input = $this->getInputIdentifier('A');
        $not = $this->getOutputIdentifier('Not A');

        $code = "$not = !($input);\n";
        return $code;
    }
}
