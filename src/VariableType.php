<?php

namespace Rhoban\Blocks;

/**
 * VariableType
 */
class VariableType
{
    const Integer = 0;
    const Scalar = 1;
    const String = 2;
    const Unknown = 3;

    /**
     * Is the given type numeric ?
     *
     * @param type the type to test
     *
     * @return true if it's a numeric type
     */
    public static function isNumeric($type)
    {
        return ($type == self::Integer || $type == self::Scalar);
    }

    /**
     * Returns the variable type corresponding to a string
     */
    public static function stringToType($type)
    {
        switch ($type) {
        case 'guess':
            return self::Unknown;
            break;
        case 'check':
        case 'integer':
            return self::Integer;
        case 'text':
        case 'string':
            return self::String;
            break;
        }

        return self::Scalar;
    }

    /**
     * Get the weakest existing type
     */
    public static function getWeakest()
    {
        return self::Integer;
    }
}
