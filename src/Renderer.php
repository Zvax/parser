<?php

namespace Zvax\Templating;

interface Renderer {

    public function render($template,$value = null);

}