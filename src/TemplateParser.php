<?php

namespace Templating;

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

    public function replaceVars($templateString, array $values)
    {
        $callback = function($match) use ($values)
        {
            $key = trim($match[0],'{$}');
            return isset($values[$key]) ? $values[$key] : $key;
        };
        return preg_replace_callback(Regexes::VARIABLE_REGEX,$callback,$templateString);
    }

}