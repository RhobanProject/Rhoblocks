<?php

namespace Rhoban\Blocks\Implementation\Arduino;

use Rhoban\Blocks\Implementation\C\Generator as Base;
use Rhoban\Blocks\Template;
use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\Implementation\Arduino\Environment;
use Rhoban\Blocks\Tools\CIndent;

class Generator extends Base
{
    public function generateCode(EnvironmentInterface $environment, $initCode, $transitionCode)
    {
        if (!$environment instanceof Environment) {
            throw new \RuntimeException('The environment should be an Arduino environment');
        }

        $prefix = $environment->getOption('prefix');
        $structName = $environment->getStructName($prefix);

        $sketchTemplate = new Template(__DIR__.'/templates/sketch.pde');

        $files = array(
            $prefix.'.pde' => CIndent::indent($sketchTemplate->render(array(
                'ticksIdentifier' => $environment->getTicksIdentifier(false),
                'headers' => $environment->getHeaders(),
                'prefix' => $prefix,
                'structName' => $structName,
                'structCode' => $environment->generateStructCode(),
                'transitionInitCode' => $environment->generateInitTransitionCode(),
                'initCode' => $initCode,
                'transitionCode' => $transitionCode,
                'generateMain' => $environment->getOption('generateMain'),
                'period' => (int)(1000/$environment->getFrequency()),
                'frequency' => (int)($environment->getFrequency()),
                'printf' => $environment->getOption('supportPrintf'),
                'baudrate' => $environment->getOption('baudrate')
            )))
        );

        return $files;
    }
}
