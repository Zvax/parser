<?php

namespace Zvax\Templating;


use Storage\Loader;

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
    
    private $regexes = [
        '\Zvax\Templating\getStringReplacementCallback' => Regexes::STRING_REGEX,
        '\Zvax\Templating\getVariableReplacementCallback' => Regexes::VARIABLE_REGEX,
        '\Zvax\Templating\getPropertyReplacementCallback' => Regexes::PROPERTY_REGEX,
        '\Zvax\Templating\getForeachReplacementCallback' => Regexes::FOREACH_REGEX,
        //'old_variables' => '/\$\w+/',
        //'functions' => '/{[\w]+\(\)}/',
        //'flow' => '/{\w+ \w+=\w+}/',
    ];
    
    private $isStringParser = true;
    private $loader;
    
    public function __construct(Loader $loader = null)
    {
        if ($loader !== null)
        {
            $this->loader = $loader;
            $this->isStringParser = false;
        }
    }

    private function getTemplateString($template)
    {
        if ($this->isStringParser)
        {
            return $template;
        }
        else
        {
            if ($this->loader->exists($template))
            {
                return $this->loader->getAsString($template);
            }
            else
            {
                return $template;
            }
        }
    }

    public function render($template, $value = null)
    {
        $templateString = $this->getTemplateString($template);

        if ($value === null)
        {
            return $templateString;
        }
        else
        {
            return $this->parse($templateString, $value);
        }
    }
    
    private function parse($string, $context)
    {
        foreach ($this->regexes as $callbackCaller => $regex)
        {
            $string = preg_replace_callback($regex, $callbackCaller($context, $this), $string);
        }
        return $string;
    }
    
    

}