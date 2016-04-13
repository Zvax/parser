<?php

namespace Zvax\Templating;

use Zvax\Templating\Exceptions\InvalidFileException;

abstract class Template implements Renderer {
    public function render($template, $value = null)
    {
        if (!file_exists($template)) {
            throw new InvalidFileException($template);
        }
        ob_start();
        require $template;
        return ob_get_clean();
    }
}