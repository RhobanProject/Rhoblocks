<?php

namespace Rhoban\Blocks\Implementation\Interpreter;

use Rhoban\Blocks\Generator as Base;
use Rhoban\Blocks\Template;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Implementation\C\Environment;
use Rhoban\Blocks\Tools\CIndent;

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
