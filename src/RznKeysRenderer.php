<?php

namespace Templating;

use Storage\Loader;

class RznKeysRenderer implements Renderer
{
    public function __construct(private Loader $loader)
    {
    }

    public function render($template, $values = null): string
    {
        $string = preg_replace_callback(
            Regexes::STRING_REGEX,
            \Templating\getStringReplacementCallback($values),
            $this->loader->getAsString($template)
        );
        return $string;
    }
}
