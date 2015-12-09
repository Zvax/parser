<?php

namespace Templating;

use Templating\Exceptions\InvalidFileException;

abstract class Template implements Renderer {

    public function render($template, $value = null)
    {
        ob_start();
        if (!file_exists($template)) {
            throw new InvalidFileException($template);
        }
        require $template;
        return ob_end_flush();
    }

}