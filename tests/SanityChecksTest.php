<?php

namespace Tests;

use Storage\FileLoader;
use Zvax\Templating\Engine;
use Zvax\Templating\PhpTemplatesRenderer;

class SanityChecksTest extends BaseTestCase
{
    public function testNotRendered()
    {
        $engine = new Engine();
        $string = $engine->render('{$defined}{$undefined}',[
            'defined' => ''
        ]);
        $this->assertEquals('{$undefined}',$string);
        // only the {$undefined} is undefined,
        // it should appear in the output
    }

    public function testEmptyValuesNotRender()
    {
        $engine = new Engine();
        $o = new \stdClass();

        $o->nullValue = null;
        $o->falseValue = false;
        $o->emptyString = '';

        $this->assertEquals('', $engine->render('{$this->nullValue}', $o));
        $this->assertEquals('', $engine->render('{$this->falseValue}', $o));
        $this->assertEquals('', $engine->render('{$this->emptyString}', $o));

        $a = [
            'nullValue' => null,
            'falseValue' => false,
            'emptyString' => '',
        ];
        $this->assertEquals('', $engine->render('{$nullValue}', $a));
        $this->assertEquals('', $engine->render('{$falseValue}', $a));
        $this->assertEquals('', $engine->render('{$emptyString}', $a));

        $a = [
            '{zNullValue}' => null,
            '{zFalseValue}' => false,
            '{zEmptyString}' => '',
        ];
        $this->assertEquals('', $engine->render('{zNullValue}', $a));
        $this->assertEquals('', $engine->render('{zFalseValue}', $a));
        $this->assertEquals('', $engine->render('{zEmptyString}', $a));

    }

    public function testPhpRendererDoesntSuckWhenTemplateNotThere()
    {
        $loader = new FileLoader('./');
        $renderer = new PhpTemplatesRenderer($loader);
        $this->expectOutputString('there is no template for [ i-don-t-exist ]');

        echo $renderer->render('i-don-t-exist');

    }
}