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
     * @param $name : the block identifier
     * @param $type : Integer or Scalar type
     * @param $dimension : The size of the declaration
     */
    public function registerState($name, $index, $type, $dimension);
    public function registerVariable($name, $index, $type, $dimension);

    /**
     * Gets the frequency of the machine
     *
     * @return the scheduling frequency in hertz
     */
    public function getFrequency();
}
