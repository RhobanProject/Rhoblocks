<?php

namespace Rhoban\Blocks\Implementation\Interpreter;

use Rhoban\Blocks\Generator as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Implementation\C\Environment;

class Generator extends Base
{
    /**
     * @inherit
     */
    public function generateCode(EnvironmentInterface $environment, $initCode, $transitionCode)
    {
        throw new \RuntimeException('The Interpreter family cannot be compiled');
    }
}
