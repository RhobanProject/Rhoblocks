<?php

namespace Rhoban\Blocks;


/**
 * EnvironmentInterface
 */
interface EnvironmentInterface
{
    /**
     * Register a global input/output/variable or a
     * stack state
     * @param $index : an unsigned unique identifier
     * @param $blockId : the block identifier
     * @param $type : Integer or Scalar type
     */
    public function registerState($blockId, $index, $type);
    public function registerVariable($blockId, $index, $type);

    /**
     * Gets the frequency of the machine
     *
     * @return the scheduling frequency in hertz
     */
    public function getFrequency();
}
