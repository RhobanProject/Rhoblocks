<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\OrBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class OrBlock extends Base
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
        $or = $this->getOutputIdentifier('Or');
        $terms = array();

        foreach ($this->getInputIdentifiers('Terms') as $term) {
            $terms[] = $term->asInteger();
        }

        if (count($terms)) {
            $code = "$or = ".implode('||',$terms).";\n";
        } else {
            $code = "$or = 0;\n";
        }

        return $code;
    }
}
