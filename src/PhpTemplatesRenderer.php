<?php

namespace Templating;

use Storage\File;
use Storage\FileLoader;

class PhpTemplatesRenderer implements Renderer
{
    public function __construct(private FileLoader $loader)
    {
    }

    public function render($template, $values = null): string
    {
        if (!$this->loader->exists($template)) {
            return "there is no template for [ $template ]";
        }
        ob_start();
        $this->activate($this->loader->load($template), $values);
        return ob_get_clean();
    }

    private function activate(File $file, $value): void
    {
        $scope = function () use ($file) {
            require $file;
        };
        if ($value === null) {
            $scope = $scope->bindTo($this);
        } else {
            if (is_array($value)) {
                $this->makeObject($value);
                $scope = $scope->bindTo($this);
            } else {
                // dangerously assume that if value is not null and not an array, that it is a view object
                $scope = $scope->bindTo($value);
            }
        }
        $scope();
    }

    private function makeObject(array $value): void
    {
        foreach ($value as $key => $content) {
            $this->$key = $content;
        }
    }
}
