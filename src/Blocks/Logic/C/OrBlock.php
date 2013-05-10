<?php

namespace Rhoban\Blocks\Blocks\Logic\C;

use Rhoban\Blocks\Blocks\Logic\Meta\OrBlock as Base;

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

        $size = $this->getInputSize('Term #');
        for ($i=0; $i<$size; $i++) {
            $input = $this->getInputIdentifier(array('Term #', $i));
            $terms[] = $input->asInteger();
        }

        if (count($terms)) {
            $code = "$or = ".implode('||',$terms).";\n";
        } else {
            $code = "$or = 0;\n";
        }

        return $code;
    }
}
