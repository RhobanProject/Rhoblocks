<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Generator;
use Rhoban\Blocks\EnvironmentInterface;

class Generator_C extends Generator
{
    /**
     * @inherit
     */
    public function generateCode($prefix, EnvironmentInterface $environment, $initCode, $transitionCode)
    {
        if (!$environment instanceof Environment_C) {
            throw new \RuntimeException('The environment should be a C environment');
        }

        $prefixUpper = strtoupper($prefix);
        $structName = $environment->getStructName($prefix);

        $codeHeader = "";
        $codeHeader .= '#ifndef '.$prefixUpper."_H\n";
        $codeHeader .= '#define '.$prefixUpper."_H\n";
        $codeHeader .= "\n";
        $codeHeader .= "typedef int integer;\n";
        $codeHeader .= "typedef float scalar;\n";
        $codeHeader .= "\n";
        $codeHeader .= $environment->generateStructCode($prefix);
        $codeHeader .= "\n";
        $codeHeader .= 'void '.$prefix."Init();\n";
        $codeHeader .= 'void '.$prefix."Tick();\n";
        $codeHeader .= "\n";
        $codeHeader .= "#endif\n";
        
        $codeC = "";
        foreach ($environment->getHeaders() as $header) {
            $codeC .= '#include <'.$header.">\n";
        }
        $codeC .= '#include \"'.$prefix.".h\"\n";
        $codeC .= "\n";
        $codeC .= 'void '.$prefix.'Init(struct '.$structName." *data)\n";
        $codeC .= "{\n";
        $codeC .= $initCode;
        $codeC .= "}\n";
        $codeC .= "\n";
        $codeC .= 'void '.$prefix.'Tick(struct '.$structName." *data)\n";
        $codeC .= "{\n";
        $codeC .= $environment->generateInitTransitionCode();
        $codeC .= "\n";
        $codeC .= $transitionCode;
        $codeC .= "}\n";

        return array(
            $prefix.'.h' => $codeHeader,
            $prefix.'.c' => $codeC,
        );
    }
}
