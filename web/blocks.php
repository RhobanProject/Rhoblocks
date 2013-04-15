<?php
session_start();

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;
use Rhoban\Blocks\ArchiveWriter;

include('../src/autoload.php');
include('../vendor/geshi/geshi.php');

function getCompiler($jsonData = null) {
    return new Compiler(new Factory('C', array('watchOutputs' => array(0))), $jsonData);
}

header('Content-type: text/plain');
$response = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'getBlocks') {
        // Generation of the blocks
        $response = '['.implode(',', getCompiler()->generateJSON()).']';
    }

    if ($action == 'getScene') {
        if (isset($_SESSION['scene'])) {
            $response = $_SESSION['scene'];
        } else {
            $response = 'null';
        }
    }

    if ($action == 'compile' && isset($_POST['data'])) {
        try {
            $_SESSION['scene'] = $_POST['data'];
            $files = getCompiler($_POST['data'])->generateCode();

            $archive = new ArchiveWriter('output');
            $name = $archive->writeFiles($files);
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.dirname($_SERVER['REQUEST_URI']).'/'.$name;

            $files = array(
                'script.sh' => "wget $url -O blocks.tgz &&\ntar zxvf blocks.tgz &&\nmake &&\n./blocks"
            );

            foreach ($files as $name => &$contents) {
                $geshi = new \GeSHi($contents, 'sh');
                $geshi->enable_classes();
                $geshi->enable_keyword_links(false);

                $contents = '<div class="highlight">'.$geshi->parse_code().'</div>';
            }

            $response = array('status' => 'ok', 'files' => $files);
        } catch (\Exception $exception) {
            $response = array('status' => 'error', 'message' => $exception->getMessage());
        }

        $response = json_encode($response);

    }

}

echo $response;
