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

        $size = $this->getInputSize('Terms');
        for ($i=0; $i<$size; $i++) {
            $input = $this->getInputIdentifier(array('Terms', $i));
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
