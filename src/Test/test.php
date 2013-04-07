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
    {"edges":[{"block1":6,"io1":"output_0","block2":8,"io2":"input_0"},{"block1":7,"io1":"output_0","block2":8,"io2":"input_1"},{"block1":10,"io1":"output_0","block2":11,"io2":"input_1"},{"block1":8,"io1":"output_0","block2":11,"io2":"input_0"},{"block1":11,"io1":"output_0","block2":9,"io2":"input_0"}],"blocks":[{"id":6,"x":-443.56872727272713,"y":-192.8833636363636,"type":"Constant","parameters":{"Value":"1"}},{"id":7,"x":-445.49909090909085,"y":-112.79672727272727,"type":"Constant","parameters":{"Value":"4"}},{"id":8,"x":-229.83136363636356,"y":-151.4769090909091,"type":"Smaller","parameters":{}},{"id":9,"x":161.30181818181825,"y":-55.63090909090906,"type":"Output","parameters":{"Index":"0"}},{"id":10,"x":-415.4958181818181,"y":21.970909090909103,"type":"Constant","parameters":{"Value":"0.25"}},{"id":11,"x":-139.23509090909081,"y":-24.07254545454544,"type":"Smaller","parameters":{}}]}
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
