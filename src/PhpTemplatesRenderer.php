<?php
namespace Templating;
use Storage\File;
use Storage\FileLoader;
class PhpTemplatesRenderer implements Renderer
{
    private $loader;
    public function __construct(FileLoader $loader)
    {
        $this->loader = $loader;
    }
    public function render($template, $value = null)
    {
        if (!$this->loader->exists($template))
        {
            return "there is no template for [ $template ]";
        }
        ob_start();
        $this->activate($this->loader->load($template), $value);
        return ob_get_clean();
    }
    private function activate(File $file, $value)
    {
        $scope = function () use ($file) { require $file; };
        if ($value === null)
        {
            $value = new \stdClass();
        }
        else
        {
            if (is_array($value))
            {
                $value = $this->makeObject($value);
            }
        }
        $scope = $scope->bindTo($value);
        $scope();
    }
    private function makeObject(array $value)
    {
        $newValue = new \stdClass();
        foreach ($value as $key => $content)
        {
            $newValue->$key = $content;
        }
        return $newValue;
    }
}
