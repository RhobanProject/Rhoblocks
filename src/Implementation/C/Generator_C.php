<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Generator;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Implementation\C\Environment_C;

class Generator_C extends Generator
{
    /**
     * @inherit
     */
    public function generateCode
        (EnvironmentInterface $environment, $initCode, $transitionCode)
    {
        if (!$environment instanceof Environment_C) {
            throw new \RuntimeException
                ('The environment should be a C environment');
        }

        $codeHeader = "";
        $codeHeader .= "#ifndef BLOCKS_H\n";
        $codeHeader .= "#define BLOCKS_H\n";
        $codeHeader .= "\n";
        $codeHeader .= "typedef int integer;\n";
        $codeHeader .= "typedef float scalar;\n";
        $codeHeader .= "\n";
        $codeHeader .= $environment->generateStructCode();
        $codeHeader .= "\n";
        $codeHeader .= "void blocksInit();\n";
        $codeHeader .= "void blocksTick();\n";
        $codeHeader .= "\n";
        $codeHeader .= "#endif\n";
        
        $codeC = "";
        foreach ($environment->getHeaders() as $header) {
            $codeC .= '#include <'.$header.">\n";
        }
        $codeC .= "#include \"Blocks.h\"\n";
        $codeC .= "\n";
        $codeC .= "void blocksInit()\n";
        $codeC .= "{\n";
        $codeC .= $initCode;
        $codeC .= "}\n";
        $codeC .= "\n";
        $codeC .= "void blocksTick()\n";
        $codeC .= "{\n";
        $codeC .= $environment->generateInitTransitionCode();
        $codeC .= "\n";
        $codeC .= $transitionCode;
        $codeC .= "}\n";

        return array(
            'Blocks.h' => $codeHeader,
            'Blocks.c' => $codeC,
        );
    }
}
