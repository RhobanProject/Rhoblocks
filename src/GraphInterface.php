<?php

namespace Rhoban\Blocks;

/**
 * GraphInterface
 */
interface GraphInterface
{
    /**
     * Generate from all blocks initialization and transition
     * code implementation
     *
     * @return string code
     */
    public function generateInitCode();
    public function generateTransitionCode();
}
