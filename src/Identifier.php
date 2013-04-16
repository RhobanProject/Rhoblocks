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
     * Is the identifier in the strut ?
     */
    protected $struct;

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
        (EnvironmentInterface $environment, $value, $type, $struct = false)
    {
        $this->environment = $environment;
        $this->value = $value;
        $this->type = $type;
        $this->struct = $struct;
    }

    /**
     * Get the value of the identifier
     */
    public function getValue($noPrefix = false)
    {
        $value = $this->value;

        if ($this->struct && !$noPrefix) {
            $value = "data->$value";
        }

        return $value;
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
