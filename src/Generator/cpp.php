<?php

include(__DIR__.'/../autoload.php');

use Rhoban\Blocks\Interpreter\Cpp\Generator;

try {
    $generator = new Generator(__DIR__.'/output/');
    $generator->generate();
} catch (\Exception $e) {
    echo 'Error during genration: '.$e->getMessage()."\n";
    exit(0);
}

echo "Generation over.\n";
