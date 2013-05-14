#!/usr/bin/php
<?php

include(__DIR__.'/../src/autoload.php');

use Rhoban\Blocks\Interpreter\Cpp\Generator;
use Rhoban\Blocks\Interpreter\Cpp\Kernel;

$kernel = new Kernel();

// You can extend the kernel and adds it some modules
// $kernel->addModule(Vendor\MyThirdPartyModule);

try {
    $generator = new Generator(__DIR__.'/blocks/', $kernel);
    $generator->generate();
} catch (\Exception $e) {
    echo 'Error during genration: '.$e->getMessage()."\n";
    exit(0);
}

echo "Generation over.\n";
