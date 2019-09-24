<?php declare(strict_types=1);

namespace Templating;

use Twig\Environment;
use Twig\Error;

class TwigAdapter implements Renderer
{
    private $twigEnvironment;

    public function __construct(Environment $twig)
    {
        $this->twigEnvironment = $twig;
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
        return $this->twigEnvironment->render($template, $values);
    }
}