<?php

namespace Templating;

use Storage\Loader;

class RznKeysRenderer implements Renderer
{
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function render($template, $values = null)
    {
        $string = preg_replace_callback(
            TemplateParser::STRING_REGEX,
            getStringReplacementCallback($values),
            $this->loader->getAsString($template)
        );
        return $string;
    }
}