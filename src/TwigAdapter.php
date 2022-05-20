<?php declare(strict_types=1);

namespace Templating;

use Twig\Environment;
use Twig\Error;

class TwigAdapter implements Renderer
{
    public function __construct(private Environment $twigEnvironment, private ?string $template_name_append = null)
    {
    }

    /**
     * @param string $template
     * @param array $values
     * @return string
     * @throws Error\LoaderError
     * @throws Error\RuntimeError
     * @throws Error\SyntaxError
     */
    public function render(string $template, array $values = []): string
    {
        if ($this->template_name_append !== null) {
            $template .= $this->template_name_append;
        }

        return $this->twigEnvironment->render($template, $values);
    }
}