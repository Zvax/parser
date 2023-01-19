<?php declare(strict_types=1);

namespace Zvax\Templating;

use Zvax\Storage\Loader;

/**
 * Class Engine
 * @package Templating
 *
 * the engine should do everything
 * take a loader, or not (in which case it would only render string templates)
 * detect which type of template is being rendered from what it will detect in it
 * parse the keys with the values that have been passed
 * the values could be an array or an object
 *
 */
class Engine implements Renderer
{
    private array $regexes = [
        'Zvax\Templating\getStringReplacementCallback' => Regexes::STRING_REGEX,
        'Zvax\Templating\getVariableReplacementCallback' => Regexes::VARIABLE_REGEX,
        'Zvax\Templating\getPropertyReplacementCallback' => Regexes::PROPERTY_REGEX,
        'Zvax\Templating\getForeachReplacementCallback' => Regexes::FOREACH_REGEX,
        //'old_variables' => '/\$\w+/',
        //'functions' => '/{[\w]+\(\)}/',
        //'flow' => '/{\w+ \w+=\w+}/',
    ];
    private bool $isStringParser = true;

    public function __construct(private readonly ?Loader $loader = null)
    {
        if ($loader !== null) {
            $this->isStringParser = false;
        }
    }

    private function getTemplateString(string $template): string
    {
        if ($this->isStringParser) {
            return $template;
        }

        if ($this->loader->exists($template)) {
            return $this->loader->getAsString($template);
        }

        return $template;
    }

    public function render(string $template, mixed $values = []): string
    {
        $templateString = $this->getTemplateString($template);
        if ($values === null) {
            return $templateString;
        }

        return $this->parse($templateString, $values);
    }

    private function parse(string $string, mixed $context): string
    {
        foreach ($this->regexes as $callbackCaller => $regex) {
            $string = preg_replace_callback($regex, $callbackCaller($context, $this), $string);
        }
        return $string;
    }
}
