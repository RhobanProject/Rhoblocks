<?php

namespace Rhoban\Blocks\Tests;

use Rhoban\Blocks\Implementation\C\Kernel as CKernel;

use Rhoban\Blocks\Factory;
use Rhoban\Blocks\Compiler;

class SceneTests extends \PHPUnit_Framework_TestCase
{
    protected function doTest($sceneFile)
    {
        $scene = file_get_contents(__DIR__.'/'.$sceneFile);

        $kernel = new CKernel;
        $compiler = new Compiler($kernel, $scene);
        $files = $compiler->generateCode();
        $this->assertTrue(count($files) > 0);
    }

    public function testWorkingScenes()
    {
        $dirname = __DIR__ . '/scenes';
        $dir = opendir($dirname);

        while ($scene = readdir($dir)) {
            if (preg_match('#\.json$#mUsi', $scene)) {
                $this->doTest('scenes/'.$scene);
            }
        }
    }

    public function testEmptyLoading()
    {
        $this->setExpectedException('Rhoban\Blocks\Exceptions\LoadingException');
        $this->doTest('badscenes/nothing.json');
    }

    public function testEmptyValue()
    {
        $this->setExpectedException('Rhoban\Blocks\Exceptions\LoadingException');
        $this->doTest('badscenes/emptyvalue.json');
    }
}
