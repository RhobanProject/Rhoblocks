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
     * Adding specific options
     */
    public function getDefaultOptions()
    {
        return array_merge(parent::getDefaultOptions(), array(
            'watchOutputs' => false
        ));
    }

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
     * Returns the name of a certain type
     */
    public function typeToName($type)
    {
        if ($type == VariableType::Integer) {
            return 'integer';
        } else if ($type == VariableType::Scalar) {
            return 'scalar';
        } else {
            throw new \RuntimeException('Unsupported type '.$type);
        }
    }

    /**
     * @inherit
     */
    public function generateStructCode()
    {
        $code = 'struct '.$this->getStructName()." {\n";
        foreach ($this->global as $identifier => $type) {
            $code .= '    '.$this->typeToName($type).' '.$identifier.";\n";
        }
        $code .= "};\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function getStructName()
    {
        $prefix = $this->getPrefix();
        return $prefix . '_data';
    }

    /**
     * @inherit
     */
    public function generateInitTransitionCode()
    {
        $code = '';
        foreach ($this->stack as $identifier => $type) {
            $code .= '    '.$this->typeToName($type).' '.$identifier.";\n";
        }

        return $code;
    }

    /**
     * @inherit
     */
    public function cast($value, $fromType, $toType)
    {
        return '('.$this->typeToName($toType).')('.$value.')';
    }
}

