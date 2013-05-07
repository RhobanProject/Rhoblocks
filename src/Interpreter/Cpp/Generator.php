<?php

namespace Rhoban\Blocks\Interpreter\Cpp;

use Rhoban\Blocks\Template;
use Rhoban\Blocks\Tools\CIndent;

/**
 * Generator for the C++ interpreter
 */
class Generator
{
    protected $targetDirectory;
    public $files;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;

        if (!$targetDirectory) {
            throw new \RuntimeException('No target directory specified');
        }

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }
    }

    public static $blockNames = array(
            'Signal.Constant', 'Signal.Pulse',
            'Time.Chrono',
            'IO.Print',
            'Math.Expression'
            /*
            'Signal.EdgeDetector', 'Signal.Square', 'Signal.Gain', 'Signal.Multiplexer', 'Signal.Demultiplexer',
            'Time.Delay', 'Time.Debounce',
            'Signal.Sinus', 'Signal.Triangle', 'Signal.Gains', 'Signal.Hysteresis',
            'IO.Output',
             'Math.Smaller', 'Math.Expression', 'Math.VariationBound',
            'Math.Discount', 'Math.Greater', 'Math.PID', 'Math.MinMax',
            'Math.DerivativeDriver', 'Math.Min', 'Math.Max', 'Math.Sum', 'Math.Equal', 'Math.Derivate',
            'Logic.Counter', 'Logic.Memory', 'Logic.And', 'Logic.Or', 'Logic.Not', 'Logic.Xor',
            'Loop.Loop'
             */
    );

    /**
     * Getting all blocks
     */
    protected function getBlocks()
    {
        $blocks = static::$blockNames;

        foreach ($blocks as &$block) {
            $parts = explode('.', $block);

            $className = 'Rhoban\\Blocks\\Blocks\\'.$parts[0].'\\'.$parts[1].'Block';
            $block = new BlockGenerator($parts, $className::meta());
        }

        return $blocks;
    }

    /**
     * Runs the generation of the code
     */
    public function generate()
    {
        $this->files = array();
        $blocks = $this->getBlocks();

        foreach ($blocks as $block) {
            $block->generateHeader($this);
            $block->generateCode($this);
        }

        $this->render('Loader.cpp', 'blocks/Loader.cpp', array('blocks' => $blocks));
        $this->copyFile('Loader.h', 'blocks/Loader.h');

        $files = array('Scene', 'Block', 'Edge', 'Index', 'Scheduler' ,'JsonUtil');
        foreach ($files as $file) {
            $this->copyFile($file.'.h', 'blocks/'.$file.'.h');
            $this->copyFile($file.'.cpp', 'blocks/'.$file.'.cpp');
        }

        $this->copyFile('main.cpp', 'main.cpp');
        $this->render('CMakeLists.txt', 'CMakeLists.txt', array('blocks' => $blocks, 'files' => $files));
    }

    /**
     * Render a template to the destination with the given $variables
     */
    public function render($template, $destination, array $variables = array(), $cindent = true)
    {
        $template = new Template(__DIR__.'/templates/'.$template);
        $data = $template->render($variables);
        if ($cindent) {
            $data = CIndent::indent($data);
        }
        $this->writeFile($destination, $data);
    }

    /**
     * Copy $source to target
     */
    public function copyFile($source, $destination)
    {
        $source = __DIR__.'/templates/'.$source;
        $fullName = $this->targetDirectory . '/' . $destination;
        $this->checkFileDirectory($fullName);

        if (!file_exists($fullName) || file_get_contents($source)!=file_get_contents($fullName)) {
            shell_exec('cp -R '.$source.' '.$fullName);
        }
    }

    /**
     * Write all the files
     */
    public function writeFiles(array $files = array())
    {
        foreach ($files as $name => $contents) {
            $this->writeFile($name, $contents);
        }
    }

    /**
     * Write a file to the output directory
     */
    public function writeFile($name, $contents)
    {
        $fullName = $this->targetDirectory . '/' . $name;
        $this->checkFileDirectory($fullName);

        if (!file_exists($fullName) || file_get_contents($fullName) != $contents) {
            file_put_contents($fullName, $contents);
        }
    }

    /**
     * Write a file
     */
    public function checkFileDirectory($name)
    {
        $directory = dirname($name);
        @mkdir($directory, 0755, true);
    }
}
