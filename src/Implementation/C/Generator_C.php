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
        $codeC .= '#include "'.$prefix.".h\"\n";
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
            'main.c' => $this->generateMain($prefix, $environment)
        );
    }

    /**
     * @inherit
     */
    public function generateMain($prefix, EnvironmentInterface $environment)
    {
        $outputs = '';

        $watch = $environment->getOption('watchOutputs');
        if ($watch) {
            $outputs .= "printf(\"\\n\");\n";
            foreach ($watch as $index) {
                $outputs .= "printf(\"Output $index: %f\\n\", data.output_$index);\n";
            }
        }

        $code = "#include <stdlib.h>
        #include <stdio.h>
        #include \"$prefix.h\"

        int main()
        {
            struct ".$environment->getStructName($prefix)." data;

            // Initializing the structure
            ".$prefix."Init(&data);

            while(1) {
                // Ticking the structure
                ".$prefix."Tick(&data);

                // You can do some display or code here
                $outputs        
                    
                usleep(1000000/".$environment->getFrequency().");
            }
        }\n";

        return $code;
    }
}
