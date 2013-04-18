<?php

namespace Rhoban\Blocks\Implementation\Arduino\IO;

use Rhoban\Blocks\Implementation\C\IO\PrintBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

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
        return parent::implementTransitionCode();
    }
}
