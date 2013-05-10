<?php

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;

use Rhoban\Blocks\Implementation\Arduino\Kernel;

include(__DIR__.'/../autoload.php');

$jsonData = file_get_contents('scene.json');

$options = array(
    'frequency' => 30,
    'watchOutputs' => array(0),
    'prefix' => 'test'
);

$compiler = new Compiler(new Kernel($options), $jsonData);

// Generation of the blocks
$jsonBlocks = $compiler->generateJSON();
foreach ($jsonBlocks as $name => $js) {
    echo "blocks.register($js);\n";
}
exit(0);

// Generation of the code files
$codeFiles = $compiler->generateCode();
foreach ($codeFiles as $file => $code) {
    echo "\n".$file.":\n\n";
    echo $code;
    if (is_dir('out')) {
        file_put_contents('out/'.$file, $code);
    }
}

// Generation of the main
//var_dump($compiler->generateMain());
