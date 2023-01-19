<?php declare(strict_types=1);

namespace Zvax\Templating;

use Zvax\Storage\Loader;

class RznKeysRenderer implements Renderer
{
    public function __construct(private readonly Loader $loader) {}

    public function render(string $template, mixed $values = []): string
    {
        return preg_replace_callback(
            Regexes::STRING_REGEX,
            getStringReplacementCallback($values),
            $this->loader->getAsString($template)
        );
    }
}
