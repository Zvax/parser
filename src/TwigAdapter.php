<?php declare(strict_types=1);

namespace Templating;

class TwigAdapter implements Renderer
{
    private $twigEnvironment;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twigEnvironment = $twig;
    }

    public function render(string $template, array $values = []): string
    {
        return $this->twigEnvironment->render($template, $values);
    }
}