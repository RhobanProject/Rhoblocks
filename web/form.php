<?php
@include(__DIR__.'/../vendor/dsd/autoload.php');

use Gregwar\DSD\Form;

$form = new Form(__DIR__.'/forms/options.html');

if (isset($_SESSION['options'])) {
    $form->setDatas($_SESSION['options']);
} else {
    $_SESSION['options'] = $form->getDatas();
}

return $form;
