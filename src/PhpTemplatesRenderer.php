<?php

namespace Templating;

use Templating\Exceptions\InvalidFileException;

class PhpTemplatesRenderer implements Renderer
{
    public function render($template, $value = null)
    {
        if (!file_exists($template))
        {
            throw new InvalidFileException($template);
        }
        ob_start();
        $scope = function() use ($template) { require $template; };
        if ($value !== null)
        {
            $scope = $scope->bindTo($value);
        }
        $scope();
        return ob_get_clean();
    }
}