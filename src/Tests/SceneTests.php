<?php

namespace Rhoban\Blocks\Tests;

use Rhoban\Blocks\Factory;
use Rhoban\Blocks\Compiler;

class SceneTests extends \PHPUnit_Framework_TestCase
{
    protected $families = array('C');

    protected function getCompiler($family, $data = null)
    {
        return new Compiler(new Factory(array('family' => $family)), $data);
    }

    protected function doTest($sceneFile)
    {
        $scene = file_get_contents(__DIR__.'/'.$sceneFile);

        foreach ($this->families as $family) {
            $compiler = $this->getCompiler($family, $scene);
            $files = $compiler->generateCode();
            $this->assertTrue(count($files) > 0);
        }
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
