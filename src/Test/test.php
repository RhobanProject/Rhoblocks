<?php

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;

/**
 * Dummy class autoload
 */
function __autoload($className) {
    $className = str_replace('Rhoban\\Blocks', '../', $className);
    $fileName = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($fileName)) {
        require($fileName);
    }
}

$jsonData = '
    {"edges":[],"blocks":[{"id":10,"x":-415.4958181818181,"y":21.970909090909103,"type":"Constant","parameters":{"Value":"0.25"}}]}
    ';

$options = array(
    'frequency' => 30,
    'watchOutputs' => array(0),
    'prefix' => 'test'
);
$compiler = new Compiler(new Factory('C', $options), $jsonData);

// Generation of the blocks
$jsonBlocks = $compiler->generateJSON();
foreach ($jsonBlocks as $name => $js) {
    echo "blocks.register($js);\n";
}
//var_dump($jsonBlocks);

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
