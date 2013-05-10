<?php

namespace Rhoban\Blocks\Blocks\Logic\C;

use Rhoban\Blocks\Blocks\Logic\Meta\AndBlock as Base;

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

        $size = $this->getInputSize('Term #');
        for ($i=0; $i<$size; $i++) {
            $input = $this->getInputIdentifier(array('Term #', $i));
            $terms[] = $input->asInteger();
        }

        if (count($terms)) {
            $code = "$and = ".implode('&&',$terms).";\n";
        } else {
            $code = "$and = 0;\n";
        }

        return $code;
    }
}