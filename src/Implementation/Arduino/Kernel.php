<?php

namespace Rhoban\Blocks\Implementation\Arduino;

use Rhoban\Blocks\Blocks\Pins\PinsModule;

use Rhoban\Blocks\Implementation\C\Kernel as Base;

class Kernel extends Base
{
    public function init()
    {
        parent::init();

        $this->addModule(new PinsModule);
    }

    public function getName()
    {
        return 'Arduino';
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

    public function classForBlock($type)
    {
        $className = $this->classForBlockTarget('Arduino', $type);

        if (!$className) {
            $className = $this->classForBlockTarget('C', $type);
        }

        return $className;
    }
}
