<?php

namespace Rhoban\Blocks\Interpreter\Cpp;

use Rhoban\Blocks\Block;
use Rhoban\Blocks\Template;

/**
 * The base of a block is the code allowing to export the block
 * and representing it
 */
class BlockGenerator
{
    protected $block = array();

    public function __construct(array $block)
    {
        $sections = array('inputs', 'outputs', 'parameters');

        foreach ($sections as $section) {
            foreach ($block[$section] as &$entry) {
                if (isset($entry['card'])) {
                    $entry['card'] = Block::parseCard($entry['card']);
                } else {
                    $entry['card'] = Block::parseCard('0-1');
                }
            }
        }

        $this->block = $block;
    }

    protected function getVariables()
    {
        $name = $this->block['name'];

        return array(
            'name' => $name,
            'upname' => strtoupper($name),
            'meta' => $this->block
        );
    }

    public function generateHeader(Generator $generator)
    {
        $name = $this->block['name'];
        $variables = $this->getVariables();

        $template = new Template(__DIR__.'/templates/implementation/'.$name.'Block.h');
        $variables['header'] = $template->render($variables);

        $generator->render('BlockImplementation.h', 'blocks/'.$name.'Block.h', $variables);
    }

    public function generateCode(Generator $generator)
    {
        $name = $this->block['name'];
        $variables = $this->getVariables();
        $codeFile = __DIR__.'/templates/implementation/'.$name.'Block.cpp';

        if (!file_exists($codeFile)) {
            throw new \RuntimeException('No implementation for block '.$name);
        }
        
        $template = new Template($codeFile);
        $variables['code'] = $template->render($variables);

        $generator->render('BlockImplementation.cpp', 'blocks/'.$name.'Block.cpp', $variables);
    }
}
