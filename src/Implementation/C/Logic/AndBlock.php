<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\AndBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class AndBlock extends Base
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
        $and = $this->getOutputIdentifier('And');
        $terms = array();

        foreach ($this->getInputIdentifiers('Terms') as $term) {
            $terms[] = $term->asInteger();
        }

        if (count($terms)) {
            $code = "$and = ".implode('&&',$terms).";\n";
        } else {
            $code = "$and = 0;\n";
        }

        return $code;
    }
}
