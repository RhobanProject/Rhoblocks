<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\VariableHolder;
use Rhoban\Blocks\VariableType;

/**
 * VariableHolder_C
 */
class VariableHolder_C extends VariableHolder
{
    /**
     * @inherit
     */
    public function generateStructCode()
    {
        $code = "struct BlocksData_t {\n";
        foreach ($this->global as $identifier => $type) {
            if ($type == VariableType::Integer) {
                $code .= '    integer '.$identifier.";\n";
            } else if ($type == VariableType::Scalar) {
                $code .= '    scalar '.$identifier.";\n";
            } else {
                throw new \RuntimeException('Unsupported type '.$type);
            }
        }
        $code .= "};\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function generateInitTransitionCode()
    {
        $code = '';
        foreach ($this->stack as $identifier => $type) {
            if ($type == VariableType::Integer) {
                $code .= '    integer '.$identifier.";\n";
            } else if ($type == VariableType::Scalar) {
                $code .= '    scalar '.$identifier.";\n";
            } else {
                throw new \RuntimeException('Unsupported type '.$type);
            }
        }

        return $code;
    }
}

