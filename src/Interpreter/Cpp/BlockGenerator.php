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
    /**
     * The meta
     */
    protected $meta = array();

    /**
     * The prefix and the name
     */
    protected $name = array();

    /**
     * Transforms a name to a fieldName, for instance "Some field"
     * will become "someField", which is a valid C variable nam that
     * can be used
     *
     * @param $originalName the name of the field
     *
     * @return the name of the field
     *
     */
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

    /**
     * Constructs a block interpreter genrator
     *
     * @param $name an array containing the directory and the name of the block
     * @param $meta, the block metas array
     */
    public function __construct(array $name, array $meta)
    {
        $sections = array('inputs', 'outputs', 'parameters');

        // Populating meta sections
        foreach ($sections as $section) {
            $entries = &$meta[$section];
            foreach ($entries as &$entry) {
                if (isset($entry['card'])) {
                    $entry['card'] = Block::parseCard($entry['card']);
                } else {
                    $entry['card'] = Block::parseCard('0-1');
                }

                // Guessing the field name if it's not set
                if (!isset($entry['fieldName'])) {
                    $entry['fieldName'] = self::transformName($entry['name']);
                }

                // Populating the "cType" of the entry
                $entry['cType'] = 'scalar';
                if (isset($entry['type'])) {
                    if ($entry['type'] == 'text' || $entry['type'] == 'textarea') {
                        $entry['cType'] = 'string';
                    }

                    if (is_array($entry['type'])) {
                        foreach ($entry['type'] as &$subEntry) {
                            $subEntry['fieldName'] = self::transformName($subEntry['name']);
                        }
                    }
                }

                // If the entry is variadic, sets the type to a map<int, type>
                if (isset($entry['length'])) {
                    $entry['cType'] = 'map<int, '.$entry['cType'].' >';
                    $entry['length'] = explode('.', $entry['length']);
                }
            }
        }

        $this->name = $name;
        $this->meta = $meta;
    }

    /**
     * Gets the block name from its meta
     *
     * @return string the block name
     */
    public function getName()
    {
        return $this->name[1];
    }

    /**
     * Gets the file name, without prefix or extension, e.g: Time/ChronoBlock
     *
     * @return string the filename
     */
    public function getFileName()
    {
        return $this->name[0].'/'.$this->name[1].'Block';
    }

    /**
     * Gets the template variables
     */
    protected function getVariables()
    {
        $name = $this->getName();

        return array(
            'name' => $name,
            'upname' => strtoupper($name),
            'meta' => $this->meta
        );
    }

    /**
     * Generates the header for the given block
     *
     * @param Generator $generator, the generator that is used
     */
    public function generateHeader(Generator $generator)
    {
        $name = $this->getName();
        $variables = $this->getVariables();

        $hFile = __DIR__.'/'.$this->getFileName().'.h';

        if (file_exists($hFile)) {
            $template = new Template($hFile);
            $variables['header'] = $template->render($variables);
        } else {
            $variables['header'] = '';
        }

        $generator->render('BlockBase.h', 'blocks/'.$this->getFileName().'Base.h', $variables);
        $generator->render('BlockImplementation.h', 'blocks/'.$this->getFileName().'.h', $variables);
    }

    /**
     * Generates the code file for the given block
     *
     * @param Generator $generator, the generator that is used
     */
    public function generateCode(Generator $generator)
    {
        $name = $this->meta['name'];
        $variables = $this->getVariables();
        $codeFile = __DIR__.'/'.$this->getFileName().'.cpp';

        if (!file_exists($codeFile)) {
            throw new \RuntimeException('No implementation for block '.$name);
        }

        $template = new Template($codeFile);
        $variables['code'] = $template->render($variables);
        $variables['sections'] = array('inputs', 'outputs', 'parameters');

        $generator->render('BlockBase.cpp', 'blocks/'.$this->getFileName().'Base.cpp', $variables);
        $generator->render('BlockImplementation.cpp', 'blocks/'.$this->getFileName().'.cpp', $variables);
    }
}
