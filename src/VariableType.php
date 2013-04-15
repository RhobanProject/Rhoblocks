<?php

namespace Rhoban\Blocks;

/**
 * VariableType
 */
class VariableType
{
    const Integer = 0;
    const Scalar = 1;
    const Unknown = 2;

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
