<?php declare(strict_types=1);

namespace Zvax\Templating;

use SplFileInfo;
use Zvax\Storage\FileLoader;

class PhpTemplatesRenderer implements Renderer
{
    public function __construct(private readonly FileLoader $loader) {}

    public function render(string $template, mixed $values = []): string
    {
        if (!$this->loader->exists($template)) {
            return "there is no template for [ $template ]";
        }
        ob_start();
        $this->activate($this->loader->load($template), $values);
        return ob_get_clean();
    }

    private function activate(SplFileInfo $file, mixed $value): void
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
