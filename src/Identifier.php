<?php

namespace Rhoban\Blocks;

use Rhoban\Blocks\EnvironmentInterface;
use Rhoban\Blocks\VariableType;

/**
 * An identifier
 */
class Identifier
{
    /**
     * The value or label of the identifier
     */
    protected $value;

    /**
     * The type of the identifier
     */
    protected $type;

    /**
     * Initialize the identifier
     * @param Rhoban\Blocks\EnvironmentInterface
     * @param $value string
     * @param $type Rhoban\Blocks\VariableType
     */
    public function __construct
        (EnvironmentInterface $environment, $value, $type)
    {
        $this->environment = $environment;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Gets the identifier, which may be casted in the target type
     * @param $type the Rhoban\Blocks\VariableType target type
     *
     * @return string identifier
     */
    public function get($type)
    {
        if ($type != $this->type) {
            return $this->environment->cast($this->value, $this->type, $type);
        }

        return $this->value;
    }

    /**
     * Return the identifier string cast as Integer and Scalar
     */
    public function asInteger()
    {
        return $this->get(VariableType::Integer);
    }
    public function asScalar()
    {
        return $this->get(VariableType::Scalar);
    }

    /**
     * Converts the identifier to a string
     */
    public function __toString()
    {
        $s = $this->get(VariableType::Scalar);
        return "$s";
    }

    /**
     * Gets the lValue (without any cast) of the identifier
     */
    public function lValue()
    {
        return $this->value;
    }
}
