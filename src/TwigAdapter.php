<?php declare(strict_types=1);

namespace Zvax\Templating;

use Twig\Environment;

class TwigAdapter implements Renderer
{
    public function __construct(
        private readonly Environment $twigEnvironment,
        private readonly ?string $template_name_append = null,
    ) {}

    public function render(string $template, mixed $values = []): string
    {
        if ($this->template_name_append !== null) {
            $template .= $this->template_name_append;
        }

        return $this->twigEnvironment->render($template, $values);
    }
}
