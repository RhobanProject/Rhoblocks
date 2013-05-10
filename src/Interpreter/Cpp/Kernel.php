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

    /**
     * A block will be supported if its module provides a Cpp/XYZBlock.cpp that 
     * implements it
     */
    public function supportsBlock($block, $module)
    {
        $module = $this->getBlockModule($block);

        $file = $module->getDirectory().'/Cpp/'.$block.'Block.cpp';

        return file_exists($file);
    }
}
