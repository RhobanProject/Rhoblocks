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
    public function generateMain()
    {
        throw new \LogicException('Main generation not implemented');
    }
}
