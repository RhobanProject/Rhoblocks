<?php

include(__DIR__.'/../autoload.php');

use Rhoban\Blocks\Kernel;

$kernel = new Kernel;

foreach ($kernel->getModules() as $module)
{
    foreach ($module->getBlocks() as $block)
    {
        var_dump($module->getMeta($block));
    }
}

