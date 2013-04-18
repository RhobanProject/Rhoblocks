<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\XorBlock as Base;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

class XorBlock extends Base
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
        $xor = $this->getOutputIdentifier('Xor');
        $terms = array();

        foreach ($this->getInputIdentifiers('Terms') as $term) {
            $terms[] = $term->asInteger();
        }

        if (count($terms)) {
            $code = "$xor = ".implode('^',$terms).";\n";
        } else {
            $code = "$xor = 0;\n";
        }

        return $code;
    }
}
