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
    public function registerInput($index, $type);
    public function registerOutput($index, $type);
    public function registerState($blockId, $index, $type);
    public function registerVariable($blockId, $index, $type);

    /**
     * Return the code for reading and writing
     * input/output/state/array variables
     * 
     * @return string
     */
    public function inputName($index);
    public function outputName($index);
    public function stateName($blockId, $index);
    public function variableName($blockId, $index);

    /**
     * Return the type of a variable
     *
     * @return Rhoban\Blocks\VariableType
     */
    public function inputType($index);
    public function outputType($index);
    public function stateType($blockId, $index);
    public function variableType($blockId, $index);

    /**
     * Try to guest the value type
     * @param $value : mixed
     *
     * @return Rhoban\Blocks\VariableType
     */
    public function guestVariableType($value);

    /**
     * Return the generated code for declaring
     * global data structure
     *
     * @return string code
     */
    public function generateStructCode($prefix);

    /**
     * Gets the struct name for a certain prefix
     */
    public function getStructName($prefix);

    /**
     * Return the generated code for initializing
     * stack variable for transition function
     *
     * @return string code
     */
    public function generateInitTransitionCode();

    /**
     * Generates the piece of code needed to cast a value from a certain 
     * type to another
     */
    public function cast($value, $fromType, $toType);
}
