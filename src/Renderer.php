<?php
namespace Templating;
interface Renderer
{
    public function render($template, $value = null);
}
