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
    {"edges":[{"block1":2,"io1":"output_0","block2":6,"io2":"input_0"},{"block1":7,"io1":"output_0","block2":2,"io2":"input_0"},{"block1":8,"io1":"output_0","block2":2,"io2":"param_1"}],"blocks":[{"id":6,"x":161.30181818181816,"y":-62.365454545454526,"type":"Output","parameters":{"Index":"0"}},{"id":2,"x":-216,"y":-118,"type":"Sinus","parameters":{"Amplitude":1,"Frequency":1,"Phase":0}},{"id":7,"x":-470.0618181818181,"y":-58.99818181818179,"type":"Chrono","parameters":{}},{"id":8,"x":-474.27090909090913,"y":-177.69454545454545,"type":"Constant","parameters":{"Value":"1"}}]}
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
