<?php

namespace Rhoban\Blocks\Implementation\Arduino;

use Rhoban\Blocks\Implementation\C\Environment as Base;

/**
 * Environment
 */
class Environment extends Base
{
    /**
     * Adding specific options
     */
    public function getDefaultOptions()
    {
        return array_merge(parent::getDefaultOptions(), array(
            'supportPrintf' => false
        ));
    }
}
