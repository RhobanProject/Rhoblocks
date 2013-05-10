<?php

namespace Rhoban\Blocks\Blocks\Math\C;

use Rhoban\Blocks\Blocks\Math\Meta\PIDBlock as Base;
use Rhoban\Blocks\VariableType;

class PIDBlock extends Base
{
    /**
     * @inherit
     */
    public function implementInitCode()
    {
        $integral = $this->getVariableIdentifier('integral', VariableType::Scalar, true);
        $lastError = $this->getVariableIdentifier('lastError', VariableType::Scalar, true);

        $code = "$integral = 0;\n";
        $code .= "$lastError = 0;\n";

        return $code;
    }

    /**
     * @inherit
     */
    public function implementTransitionCode()
    {
        $error = $this->getVariableIdentifier('error', VariableType::Scalar);
        $derivate = $this->getVariableIdentifier('derivate', VariableType::Scalar);
        $lastError = $this->getVariableIdentifier('lastError', VariableType::Scalar, true);
        $integral = $this->getVariableIdentifier('integral', VariableType::Scalar, true);
        $imin = $this->getParameterIdentifier('IMin')->asScalar();
        $imax = $this->getParameterIdentifier('IMax')->asScalar();
        $discount = $this->getParameterIdentifier('Discount')->asScalar();
        $order = $this->getInputIdentifier('Order')->asScalar();
        $actual = $this->getInputIdentifier('Actual')->asScalar();
        $command = $this->getOutputIdentifier('Command');
        $outputError = $this->getOutputIdentifier('Error');
        $P = $this->getParameterIdentifier('P')->asScalar();
        $I = $this->getParameterIdentifier('I')->asScalar();
        $D = $this->getParameterIdentifier('D')->asScalar();

        $code = "$error = ($order - $actual);\n";
        $code .= "$integral += $error * (".$this->environment->getPeriod().");\n";
        $code .= "if ($integral > $imax) {\n";
        $code .= "$integral = $imax;\n";
        $code .= "}\n";
        $code .= "if ($integral < $imin) {\n";
        $code .= "$integral = $imin;\n";
        $code .= "}\n";
        $code .= "$derivate = ($error-$lastError)/".$this->environment->getPeriod().";\n";
        $code .= "$lastError = ($discount*$lastError)+(1-$discount)*($error);\n";
        $code .= "$command = ($P*$error)+($I*$integral)+($D*$derivate);\n";
        $code .= "$outputError = $error;\n";

        return $code;
    }
}
