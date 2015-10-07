<?php

namespace Templating;

use RZN\Templating;

class Parser implements Templating {

    private $path = [];
    private $vars = [];
    private $extensions = [
        ".php",
        ".html"
    ];

    public function __construct($path,$vars = []) {
        $this->path[] = $path;
        foreach ($vars as $key => $value) {
            $this->vars[$key] = $value;
        }
    }

    public function rendre($template,array $values = []) {
        extract($this->vars);
        if (count($values) > 0) extract($values);
        ob_start();
        if (!$this->includeFile($template)) throw new \Exception("template not found: [$template]");
        return ob_get_clean();
    }

    private function includeFile($template) {
        foreach ($this->extensions as $extension) {
            $fullPath = "$this->path$template$extension";
            if (file_exists($fullPath)) {
                include $fullPath;
                return true;
            }
        }
        return false;
    }

}