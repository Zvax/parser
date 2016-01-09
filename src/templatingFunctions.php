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
        return getValueFromContext($key,$values);
    };
    return $callback;
}

function getPropertyReplacementCallback($values)
{
    $callback = function($match) use ($values)
    {
        $className = $match[2];
        $property = $match[4];
        if (isset($values->$property))
        {
            return $values->$property;
        }
        $instance = getValueFromContext($className, $values);
        return isset($instance->$property)
            ? $instance->$property
            : "$match[1]$match[2]$match[3]";
    };
    return $callback;
}

function getValueFromContext($key, $context)
{
    if (is_array($context))
    {
        return isset($context[$key]) ? $context[$key] : '';
    }
    else if (isset($context->$key))
    {
        return $context->$key;
    }
    return '';
}