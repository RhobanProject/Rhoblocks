<?php

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;

include('../src/autoload.php');
include('../vendor/geshi/geshi.php');

function getCompiler($jsonData = null) {
    return new Compiler(new Factory('C'), $jsonData);
}

header('Content-type: text/plain');
$response = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'getBlocks') {
        // Generation of the blocks
        $response = '['.implode(',', getCompiler()->generateJSON()).']';
    }

    if ($action == 'compile' && isset($_POST['data'])) {
        try {
            $files = getCompiler($_POST['data'])->generateCode();
            $response = array('status' => 'ok', 'files' => $files);
        } catch (\Exception $exception) {
            $response = array('status' => 'error', 'message' => $exception->getMessage());
        }

        $response = json_encode($response);

    }

}

echo $response;
