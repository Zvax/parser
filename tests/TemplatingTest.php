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
}