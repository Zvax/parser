<?php declare(strict_types=1);

namespace Templating;

interface Renderer
{
    public function render(string $template, array $values = []): string;
}