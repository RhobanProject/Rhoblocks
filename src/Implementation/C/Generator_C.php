<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Generator;

class Generator_C extends Generator
{
    /**
     * @inherit
     */
    public function generateCode(
        $structCode, $initCode, $initTransitionCode, $transitionCode)
    {
        $codeHeader = "";
        $codeHeader .= "#ifndef BLOCKS_H\n";
        $codeHeader .= "#define BLOCKS_H\n";
        $codeHeader .= "\n";
        $codeHeader .= "typedef int integer;\n";
        $codeHeader .= "typedef float scalar;\n";
        $codeHeader .= "\n";
        $codeHeader .= $structCode;
        $codeHeader .= "\n";
        $codeHeader .= "void blocksInit();\n";
        $codeHeader .= "void blocksTick();\n";
        $codeHeader .= "\n";
        $codeHeader .= "#endif\n";
        
        $codeC = "";
        $codeC .= "#include <math.h>\n";
        $codeC .= "#include \"Blocks.h\"\n";
        $codeC .= "\n";
        $codeC .= "void blocksInit()\n";
        $codeC .= "{\n";
        $codeC .= $initCode;
        $codeC .= "}\n";
        $codeC .= "\n";
        $codeC .= "void blocksTick()\n";
        $codeC .= "{\n";
        $codeC .= $initTransitionCode;
        $codeC .= "\n";
        $codeC .= $transitionCode;
        $codeC .= "}\n";

        return array(
            'Blocks.h' => $codeHeader,
            'Blocks.c' => $codeC,
        );
    }
}
