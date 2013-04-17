<?php
session_start();

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;
use Rhoban\Blocks\ArchiveWriter;

include('../src/autoload.php');
include('../vendor/geshi/geshi.php');

$form = @include('form.php');
$options = $_SESSION['options'];

function getCompiler($jsonData = null, $options = array()) {
    return new Compiler(new Factory('C', $options), $jsonData);
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
            $files = getCompiler($_POST['data'], $options)->generateCode();
            $files['scene.json'] = $_POST['data'];

            if ($options['archive'] == 'yes') {
                $archive = new ArchiveWriter('output');
                $name = $archive->writeFiles($files);
                $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.dirname($_SERVER['REQUEST_URI']).'/'.$name;

                $files = array(
                    'script.sh' => "wget $url -O blocks.tgz &&\ntar zxvf blocks.tgz &&\nmake &&\n./blocks"
                );
            }

            foreach ($files as $name => &$contents) {
                $geshi = new \GeSHi($contents, 'C');
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

    if ($action == 'saveOptions' && $form->posted()) {
        $options = $form->getDatas();
        $_SESSION['options'] = $options;
        var_dump($_SESSION['options']);
    }
}

echo $response;
