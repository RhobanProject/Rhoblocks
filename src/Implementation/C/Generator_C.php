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

        $files = array(
            $prefix.'.h' => $codeHeader,
            $prefix.'.c' => $codeC,
            'Makefile' => file_get_contents(__DIR__.'/templates/Makefile')
        );

        if ($environment->getOption('generateMain')) {
            $files['main.c'] = $this->generateMain($environment);
        }

        return $files;
    }

    /**
     * @inherit
     */
    public function generateMain(EnvironmentInterface $environment)
    {
        $prefix = $environment->getPrefix();
        $outputs = '';

        $mainTemplate = new Template(__DIR__.'/templates/main.c');
        $code = $mainTemplate->render(array(
            'prefix' => $prefix,
            'structName' => $environment->getStructName($prefix),
            'frequency' => $environment->getFrequency()
        ));
        
        return $code;
    }
}
