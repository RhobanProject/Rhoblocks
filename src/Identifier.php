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
     * The dimension of the variable
     */
    protected $dimension;
    
    /**
     * Is the identifier in the strut ?
     */
    protected $prefix;

    public static function guessType($variable, $type)
    {
        if ($type == VariableType::Unknown) {
            if (preg_match('#^([0-9]+)$#uSi', $variable)) {
                $variable = (int)$variable;
                $type = VariableType::Integer;
            } else {
                $variable = (double)$variable;
                $type = VariableType::Scalar;
            }
        }

        return array($variable, $type);
    }

    /**
     * Initialize the identifier
     * @param Rhoban\Blocks\EnvironmentInterface
     * @param $value string
     * @param $type Rhoban\Blocks\VariableType
     */
    public function __construct
        (EnvironmentInterface $environment, $value, $type, $prefix = '')
    {
        $this->environment = $environment;
        $this->value = $value;
        $this->type = $type;
        $this->prefix = $prefix;
    }

    /**
     * Get the value of the identifier
     */
    public function getValue()
    {
        return $this->prefix.$this->value;
    }

    public function getDeclaration()
    {
        return $this->value;
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
            return $this->environment->cast($this->getValue(), $this->type, $type);
        }

        return $this->getValue();
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
        return $this->lValue();
    }

    /**
     * Gets the lValue (without any cast) of the identifier
     */
    public function lValue()
    {
        return $this->getValue();
    }

    /**
     * Getting the type of the identifier
     */
    public function getType()
    {
        return $this->type;
    }
}
