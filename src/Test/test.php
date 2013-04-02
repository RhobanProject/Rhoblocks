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
    {"edges":[{"block1":1,"io1":"output_0","block2":2,"io2":"input_0"},{"block1":2,"io1":"output_0","block2":3,"io2":"input_0"},{"block1":4,"io1":"output_0","block2":3,"io2":"input_1"},{"block1":3,"io1":"output_0","block2":5,"io2":"param_0"}],"blocks":[{"id":1,"x":-482,"y":-90,"type":"Constant","parameters":{"Value":"10"}},{"id":2,"x":-216,"y":-118,"type":"Sinus","parameters":{"Amplitude":1,"Frequency":1,"Phase":0}},{"id":3,"x":24,"y":-5,"type":"Smaller","parameters":{}},{"id":4,"x":-234,"y":30,"type":"Constant","parameters":{"Value":"5"}},{"id":5,"x":229,"y":-5,"type":"Constant","parameters":{"Value":0}}]}
    ';

$compiler = new Compiler(new Factory('C'), $jsonData);

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
}

// Generation of the main
//var_dump($compiler->generateMain());
