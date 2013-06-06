<?php

namespace Rhoban\Blocks\Blocks\Logic\C;

use Rhoban\Blocks\Blocks\Logic\Meta\XorBlock as Base;

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

        foreach ($this->getInputIdentifiers('Terms') as $input) {
            $terms[] = $input->asInteger();
        }

        if (count($terms)) {
            $code = "$xor = ".implode('^',$terms).";\n";
        } else {
            $code = "$xor = 0;\n";
        }

        return $code;
    }
}
