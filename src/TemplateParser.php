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
    const OLD_VAR_REGEX = '/\$\w+/';
    const VAR_REGEX = '/{[\w$]+}/';
    const FUNCTION_REGEX = '/{[\w]+\(\)}/';
    const FLOW_REGEX = '/{\w+ \w+=\w+}/';
    const PROP_REGEX = '/{\$\w+\-\>\w+}/';


    public function parseVars($string)
    {
        $matches = [];
        preg_match_all(TemplateParser::VAR_REGEX,$string,$matches);
        return $matches[0];
    }
    public function parseOldVars($string)
    {
        $matches = [];
        preg_match_all(TemplateParser::OLD_VAR_REGEX,$string,$matches);
        return $matches[0];
    }
    public function parseMethods($string)
    {
        $matches = [];
        preg_match_all(TemplateParser::FUNCTION_REGEX,$string,$matches);
        return $matches[0];
    }
    public function parseFlow($string)
    {
        $matches = [];
        preg_match_all(TemplateParser::FLOW_REGEX,$string,$matches);
        return $matches[0];
    }

    public function replaceVars($templateString, array $values)
    {
        $callback = function($match) use ($values)
        {
            $key = trim($match[0],'{$}');
            return isset($values[$key]) ? $values[$key] : $key;
        };
        return preg_replace_callback(TemplateParser::VAR_REGEX,$callback,$templateString);
    }

}