<?php

namespace Rhoban\Blocks\Interpreter\Cpp;

/**
 * The base of a block is the code allowing to export the block
 * and representing it
 */
class BlockGenerator
{
    protected $block = array();

    public function __construct(array $block)
    {
        $this->block = $block;
    }

    public function generateHeader(Generator $generator)
    {
        $name = $this->block['name'];
        $generator->render('BlockImplementation.h', 'blocks/'.$name.'Block.h', array(
            'name' => $name, 
            'upname' => strtoupper($name)
        ));
    }

    public function generateCode(Generator $generator)
    {
        $name = $this->block['name'];
        $generator->render('BlockImplementation.cpp', 'blocks/'.$name.'Block.cpp', array(
            'name' => $name, 
            'upname' => strtoupper($name)
        ));
    }
}
