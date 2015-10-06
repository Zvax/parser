<?php

namespace Templating;

use RZN\Templating;

class Parser implements Templating {

    private $path;
    private $vars;

    public function __construct($path,$vars = []) {
        $this->path = $path;
        foreach ($vars as $key => $value) {
            $this->vars[$key] = $value;
        }
    }

    public function rendre($template,array $values = []) {
        extract($this->vars);
        if (count($values) > 0) extract($values);
        ob_start();
        $fullPath = $this->path.$template;
        if (file_exists($fullPath)) include $fullPath;
        return ob_get_clean();
    }

}