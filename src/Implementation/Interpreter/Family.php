<?php

namespace Rhoban\Blocks\Implementation\Interpreter;

use Rhoban\Blocks\Family as Base;
use Rhoban\Blocks\Interpreter\Cpp\Generator;

/**
 * The Interpreter family
 */
class Family extends Base
{
    protected function getBlocks()
    {
        $types = Generator::$blockNames;
        $blocks = array();

        foreach ($types as $type) {
            list($family, $name) = explode('.', $type);
            $blocks[$name] = 'Rhoban\\Blocks\\Blocks\\' . $family . '\\' . $name . 'Block';
        }

        return $blocks;
    }
}
