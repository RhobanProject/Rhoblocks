<?php

namespace Rhoban\Blocks;

/**
 * Handles a simple template docment
 */
class Template
{
    // Name of the template file
    protected $templateFile;

    public function __construct($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function render(array $variables = array())
    {
        extract($variables);
        ob_start();
        include($this->templateFile);

        return ob_get_clean();
    }
}
