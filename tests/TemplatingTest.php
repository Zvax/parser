<?php

namespace Tests;

use Storage\FileLoader;
use Zvax\Templating\PhpTemplatesRenderer;

class TemplatingTest extends BaseTestCase
{
    public function testRenders()
    {
        $view = new ExampleTemplate();
        $this->assertInstanceOf('Tests\ExampleTemplate',$view);

        $string = $view->render(__DIR__.'/templates/test_template.php');
        $this->assertInternalType('string',$string);

    }
    public function testException()
    {
        $this->setExpectedException('Zvax\Templating\Exceptions\InvalidFileException');
        $view = new ExampleTemplate();
        $view->render('nonfile');
    }

    public function testAcceptsObjectAndRendersIt()
    {
        $view = new ExampleViewObject();
        $loader = new FileLoader(__DIR__ . "/templates","php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',$view);
        $this->assertInternalType('string',$string);
        $this->assertContains('default body',$string);
    }

    public function testAcceptsArrayAndRendersValues()
    {
        $loader = new FileLoader(__DIR__ . "/templates","php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',[
            'body' => 'body from array',
        ]);
        $this->assertInternalType('string',$string);
        $this->assertContains('body from array',$string);
    }

    public function testRendersFromBasePath()
    {
        $loader = new FileLoader(__DIR__ . "/templates","php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',[
            'body' => 'whatever',
        ]);
        $this->assertInternalType('string',$string);
        $this->assertContains('whatever',$string);
    }

}