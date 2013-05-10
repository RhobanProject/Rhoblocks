<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Kernel as Base;

class Kernel extends Base
{
    public function getName()
    {
        return 'C';
    }

    public function createEnvironment()
    {
        return new Environment($this->options);
    }

    public function createGenerator()
    {
        return new Generator;
    }

    public function canBeCompiled()
    {
        return true;
    }
}
