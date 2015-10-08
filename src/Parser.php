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

    public function render($template,array $values = []) {
        extract($this->vars);
        if (count($values) > 0) extract($values);
        ob_start();
        $fullPath = $this->findPath($template);
        include $fullPath;
        return ob_get_clean();
    }

    private function findPath($template) {
        $tries = [];
        foreach ($this->path as $path) {
            foreach ($this->extensions as $extension) {
                $fullPath = "$path$template$extension";
                if (file_exists($fullPath)) {
                    return $fullPath;
                }
                $tries[] = $fullPath;
            }
        }
        throw new \Exception("templates not found: [ ".implode(" ; ",$tries)." ]");
    }

}