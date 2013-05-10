<?php

namespace Rhoban\Blocks\Blocks\Logic\C;

use Rhoban\Blocks\Blocks\Logic\Meta\NotBlock as Base;

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
