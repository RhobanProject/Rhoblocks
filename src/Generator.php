<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\GeneratorInterface;

/**
 * Generator
 */
abstract class Generator implements GeneratorInterface
{
    /**
     * @inherit
     */
    public function generateMain($prefix, EnvironmentInterface $environment)
    {
        throw new \LogicException('Main generation not implemented');
    }
}
