<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Generator;
use Rhoban\Blocks\Template;
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

        $prefix = $environment->getPrefix();
        $prefixUpper = strtoupper($prefix);
        $structName = $environment->getStructName($prefix);

        $headerTemplate = new Template(__DIR__.'/templates/header.h');
        $codeHeader = $headerTemplate->render(array(
            'prefixUpper' => $prefixUpper,
            'prefix' => $prefix,
            'structCode' => $environment->generateStructCode()
        ));

        $cTemplate = new Template(__DIR__.'/templates/code.c');
        $codeC = $cTemplate->render(array(
            'headers' => $environment->getHeaders(),
            'prefix' => $prefix,
            'structName' => $structName,
            'transitionInitCode' => $environment->generateInitTransitionCode(),
            'initCode' => $initCode,
            'transitionCode' => $transitionCode
        ));

        return array(
            $prefix.'.h' => $codeHeader,
            $prefix.'.c' => $codeC,
            'Makefile' => file_get_contents(__DIR__.'/templates/Makefile'),
            'main.c' => $this->generateMain($environment)
        );
    }

    /**
     * @inherit
     */
    public function generateMain(EnvironmentInterface $environment)
    {
        $prefix = $environment->getPrefix();
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
