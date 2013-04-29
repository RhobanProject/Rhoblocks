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

    protected static function transformName($originalName)
    {
        $name = strtolower($originalName);

        if ($name == 'default') {
            return 'defaultValue';
        }

        $name = trim(preg_replace('/[^0-9a-z ]/mUsi', '', $name));
        $words = explode(' ', $name);
        $newName = array_shift($words);
        foreach ($words as $word) {
            $newName .= ucfirst($word);
        }
        return $newName;
    }

    public function __construct(array $block)
    {
        $sections = array('inputs', 'outputs', 'parameters');

        foreach ($sections as $section) {
            $entries = &$block[$section];
            foreach ($entries as &$entry) {
                if (isset($entry['card'])) {
                    $entry['card'] = Block::parseCard($entry['card']);
                } else {
                    $entry['card'] = Block::parseCard('0-1');
                }

                if (!isset($entry['fieldName'])) {
                    $entry['fieldName'] = self::transformName($entry['name']);
                }

                $entry['cType'] = 'scalar';
                if (isset($entry['type'])) {
                    if ($entry['type'] == 'text' || $entry['type'] == 'textarea') {
                        $entry['cType'] = 'string';
                    }

                    if (is_array($entry['type'])) {
                        foreach($entry['type'] as &$subEntry) {
                            $subEntry['fieldName'] = self::transformName($subEntry['name']);
                        }
                    }
                }

                if (isset($entry['length'])) {
                    $entry['cType'] = 'map<int, '.$entry['cType'].' >';
                    $entry['length'] = explode('.', $entry['length']);
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

        $hFile = __DIR__.'/templates/implementation/'.$name.'Block.h';

        if (file_exists($hFile)) {
            $template = new Template($hFile);
            $variables['header'] = $template->render($variables);
        } else {
            $variables['header'] = '';
        }

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
        $variables['sections'] = array('inputs', 'outputs', 'parameters');

        $generator->render('BlockImplementation.cpp', 'blocks/'.$name.'Block.cpp', $variables);
    }
}
