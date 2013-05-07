<?php

namespace Rhoban\Blocks\Implementation\C\Logic;

use Rhoban\Blocks\Blocks\Logic\XorBlock as Base;

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

        $size = $this->getInputSize('Term #');
        for ($i=0; $i<$size; $i++) {
            $input = $this->getInputIdentifier(array('Term #', $i));
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
