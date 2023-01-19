<?php declare(strict_types=1);

namespace Zvax\Templating;

interface Renderer
{
    public function render(string $template, mixed $values = []): string;
}
