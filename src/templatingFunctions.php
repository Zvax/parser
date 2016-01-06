<?php

namespace Templating;

function getStringReplacementCallback($values)
{
    $fn = function($matches) use ($values)
    {
        $key = $matches[0];
        if (is_array($values) && isset($values[$key]))
        {
            return $values[$key];
        }
        return $key;
    };
    return $fn;
}

function getVariableReplacementCallback($values)
{
    $callback = function($match) use ($values)
    {
        $key = trim($match[0],'{$}');
        return isset($values[$key]) ? $values[$key] : $key;
    };
    return $callback;
}