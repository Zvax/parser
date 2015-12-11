<?php

class TemplatingTest extends \Tests\BaseTestCase
{
    public function testRenders()
    {
        $view = new \Tests\ExampleTemplate();
        $this->assertInstanceOf('Tests\ExampleTemplate',$view);

        $string = $view->render(__DIR__.'/templates/test_template.php');
        $this->assertInternalType('string',$string);

    }
    public function testException()
    {
        $this->setExpectedException('Templating\Exceptions\InvalidFileException');
        $view = new \Tests\ExampleTemplate();
        $view->render('nonfile');
    }

    public function testAcceptsObjectAndRendersIt()
    {
        $view = new \Tests\ExampleViewObject();
        $loader = new \Storage\FileLoader(__DIR__ . "/templates","php");
        $renderer = new \Templating\PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',$view);
        $this->assertInternalType('string',$string);
        $this->assertContains('default body',$string);
    }

    public function testAcceptsArrayAndRendersValues()
    {
        $loader = new \Storage\FileLoader(__DIR__ . "/templates","php");
        $renderer = new \Templating\PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',[
            'body' => 'body from array',
        ]);
        $this->assertInternalType('string',$string);
        $this->assertContains('body from array',$string);
    }

    public function testRendersFromBasePath()
    {
        $loader = new \Storage\FileLoader(__DIR__ . "/templates","php");
        $renderer = new \Templating\PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template',[
            'body' => 'whatever',
        ]);
        $this->assertInternalType('string',$string);
        $this->assertContains('whatever',$string);
    }

}