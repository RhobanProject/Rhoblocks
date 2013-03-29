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

$jsonData = '{
    "edges":[
        {"block1":11,"io1":"output_0","block2":4,"io2":"param_1"},
        {"block1":12,"io1":"output_0","block2":4,"io2":"input_0"},
        {"block1":12,"io1":"output_0","block2":4,"io2":"param_2"}
    ],"blocks":[
        {"id":11,"x":-399.29937283654135,"y":-155.48195167050062,"type":"Constant","parameters":{"Value":"2"}},
        {"id":4,"x":-55.604849866396876,"y":-101.20299460902797,"type":"Sinus","parameters":{"Amplitude":1,"Frequency":10,"Phase":0,"Invert":false}},
        {"id":12,"x":-395.74504852676955,"y":-34.48929566763786,"type":"Constant","parameters":{"Value":0}}
]}';

$compiler = new Compiler(new Factory('C'), $jsonData);

// Generation of the blocks
$jsonBlocks = $compiler->generateJSON();
var_dump($jsonBlocks);

// Generation of the code files
$codeFiles = $compiler->generateCode();
foreach ($codeFiles as $file => $code) {
    echo "\n".$file.":\n\n";
    echo $code;
}

// Generation of the main
//var_dump($compiler->generateMain());
