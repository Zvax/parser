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
    const OLD_VARIABLE_REGEX = '/\$\w+/';
    const VARIABLE_REGEX = '/{\$[\w]+}/';
    const FUNCTION_REGEX = '/{[\w]+\(\)}/';
    const FLOW_REGEX = '/{\w+ \w+=\w+}/';
    const PROPERTY_REGEX = '/{\$\w+\-\>\w+}/';
    const STRING_REGEX = '/{z[\w]+}/';

    public function replaceVars($templateString, array $values)
    {
        $callback = function($match) use ($values)
        {
            $key = trim($match[0],'{$}');
            return isset($values[$key]) ? $values[$key] : $key;
        };
        return preg_replace_callback(TemplateParser::VARIABLE_REGEX,$callback,$templateString);
    }

}