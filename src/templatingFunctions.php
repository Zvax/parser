<?php

namespace Zvax\Templating;

function getForeachReplacementCallback($context, $renderer)
{
    /**
     * @param $match
     * @return string
     * @var Engine $renderer
     */
    $fn = function ($match) use ($context,$renderer)
    {
        $key = $match[1];
        $array = getValueFromContext($key,$context);
        if (!is_array($array))
        {
            return "$key is not an array";
        }
        $subKey = $match[2];
        $template = $match[3];
        $string = '';
        foreach ($array as $value)
        {
            $string .= $renderer->render($template,[
                $subKey => $value,
            ]);
        }
        return $string;
    };
    return $fn;
}

function getStringReplacementCallback($context)
{
    $fn = function ($match) use ($context)
    {
        $key = $match[1];
        if ($value = getValueFromContext($key,$context))
        {
            return $value;
        }
        else if (strpos($match[0],'{z') === 0)
        {
            $value = getValueFromContext($match[0],$context);
            if ($value !== false)
            {
                return $value;
            }
            $subkey = strtolower(substr($key,1));
            $value = getValueFromContext($subkey,$context);
            if ($value !== false)
            {
                return $value;
            }
        }
        return $match[0];
    };
    return $fn;
}

function getVariableReplacementCallback($values)
{
    $callback = function ($match) use ($values)
    {
        $key = $match[2];
        if (($value = getValueFromContext($key,$values)) !== false)
        {
            return $value;
        }
        return $match[0];
    };
    return $callback;
}

function getPropertyReplacementCallback($values)
{
    $callback = function ($match) use ($values)
    {
        $className = $match[1];
        $property = $match[2];
        if (is_array($values))
        {
            if ($instance = getValueFromContext($className,$values))
            {
                return property_exists($instance,$property)
                    ? $instance->$property
                    : $match[0];
            }
        }
        else if(is_scalar($values))
        {
            return $values;
        }
        else if (property_exists($values,$property))
        {
            return $values->$property;
        }
        return $match[0];
    };
    return $callback;
}

function getValueFromContext($key,$context)
{
    if (is_array($context))
    {
        if (array_key_exists($key,$context))
        {
            $value = $context[$key];
            if ($value === false || $value === null)
            {
                return '';
            }
            return $value;
        }
        return false;
    }
    else if (property_exists($context,$key))
    {
        $value = $context->$key;
        if ($value === false || $value === null)
        {
            return '';
        }
        return $context->$key;
    }
    return false;
}