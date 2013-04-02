<?php

namespace Rhoban\Blocks\Implementation\C;

use Rhoban\Blocks\Environment;
use Rhoban\Blocks\VariableType;

/**
 * Environment_C
 */
class Environment_C extends Environment
{
    /**
     * Headers to add
     */
    protected $headers = array();

    /**
     * Adds an header (.h) to the includes
     *
     * @param $header the header file name
     */
    public function addHeader($header)
    {
        $this->headers[$header] = true;
    }

    /**
     * Get the header files
     */
    public function getHeaders()
    {
        return array_keys($this->headers);
    }

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

