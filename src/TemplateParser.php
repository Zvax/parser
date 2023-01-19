<?php declare(strict_types=1);

namespace Zvax\Templating;

/**
 * Class TemplateParser
 * @package Templating
 *
 * this receives a string, parses it to detect {$var} tags
 * and return an array of those tags
 *
 */
class TemplateParser
{
    /**
     * @param array<string, mixed> $values
     * @return array<string, mixed>|string|null
     */
    public function replaceVars(string $templateString, array $values): array|string|null
    {
        $callback = static function ($match) use ($values) {
            $key = trim($match[0], '{$}');
            return $values[$key] ?? $key;
        };
        return preg_replace_callback(Regexes::VARIABLE_REGEX, $callback, $templateString);
    }
}
