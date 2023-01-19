<?php declare(strict_types=1);

namespace Zvax\Templating;

use Zvax\Templating\Exceptions\InvalidFileException;

abstract class Template implements Renderer
{
    public function render(string $template, mixed $values = null): string
    {
        if (!file_exists($template)) {
            throw new InvalidFileException($template);
        }
        ob_start();
        require $template;
        return ob_get_clean();
    }
}
