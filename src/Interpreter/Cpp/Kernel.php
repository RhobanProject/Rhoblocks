<?php

namespace Rhoban\Blocks\Interpreter\Cpp;

use Rhoban\Blocks\Kernel as Base;

class Kernel extends Base
{
    public function getName()
    {
        return 'C++';
    }

    public function canBeCompiled()
    {
        return false;
    }

    public function supportsBlock($block)
    {
        $supportedBlocks = array(
            // Signal
            'Pulse', 'Constant',

            // IO
            'Print',

            // Math
            'Expression',

            // Time
            'Chrono',
        );

        return in_array($block, $supportedBlocks);
    }
}
