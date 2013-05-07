<?php
session_start();

use Rhoban\Blocks\Compiler;
use Rhoban\Blocks\Factory;
use Rhoban\Blocks\Tools\ArchiveWriter;
use Rhoban\Blocks\Tools\JsonIndent;

include '../src/autoload.php';
include '../vendor/geshi/geshi.php';

$form = @include('form.php');
$options = $_SESSION['options'];
$options['family'] = 'Interpreter';

function getCompiler($jsonData = null, $options = array())
{
    return new Compiler(new Factory($options), $jsonData);
}

header('Content-type: text/plain');
$response = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'getBlocks') {
        try {
            $response = '{"status":"ok","blocks":['.implode(',', getCompiler(null, $options)->generateJSON()).']}';
        } catch (\Exception $e) {
            $response = json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    if ($action == 'getScene') {
        if (isset($_SESSION['scene'])) {
            $response = $_SESSION['scene'];
        } else {
            $response = 'null';
        }
    }

    if (($action == 'compile' || $action == 'compileAndSend') && isset($_POST['data'])) {
        try {
            $_SESSION['scene'] = $_POST['data'];
            $files = getCompiler($_POST['data'], $options)->generateCode();

            if ($options['includeJson'] == 'yes') {
                $data = '['.json_encode($options).','.$_POST['data'].']';
                $files['scene.json'] = JsonIndent::indent($data);
            }

            if ($options['archive'] == 'yes') {
                $archive = new ArchiveWriter('output');
                $name = $archive->writeFiles($files);
                $url = 'http://'.$_SERVER['HTTP_HOST'].'/'.dirname($_SERVER['REQUEST_URI']).'/'.$name;

                $files = array(
                    'script.sh' => "wget $url -O blocks.tgz &&\ntar zxvf blocks.tgz &&\nmake &&\n./blocks"
                );
            }

            if ($action == 'compileAndSend') {
                $arduino = include(__DIR__.'/arduino/arduino.php');

                foreach ($files as $name => $contents) {
                    if (preg_match('#\.pde$#mUsi', $name)) {
                        $files = array('compile.log' => $arduino->compileAndSend($contents));
                        break;
                    }
                }
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

    if ($action == 'saveOptions' && $form->posted() && !$form->check()) {
        $options = $form->getDatas();
        $_SESSION['options'] = $options;
        $response = json_encode(1);
    }
}

echo $response;
