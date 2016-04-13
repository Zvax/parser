<?php

namespace Zvax\Templating;

use Mustache_Engine;

class MustacheRenderer implements Renderer
{
    private $Renderer;

    public function __construct(Mustache_Engine $oMustache)
    {
        $this->Renderer = $oMustache;
    }

    public function render($template, $values = [])
    {
        return $this->Renderer->render($template, $values);
    }
}