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

    public function __construct(EnvironmentInterface $environment, $value, $type)
    {
        $this->environment = $environment;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Gets the identifier, which may be casted in the target type
     */
    public function get($type)
    {
        if ($type != $this->type) {
            return $this->environment->cast($this->value, $this->type, $type);
        }

        return $this->value;
    }

    public function asInteger()
    {
        return $this->get(VariableType::Integer);
    }

    public function asScalar()
    {
        return $this->get(VariableType::Scalar);
    }


    /**
     * Converts the idntifier to a string
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
