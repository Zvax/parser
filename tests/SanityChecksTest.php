<?php

class SanityChecksTest extends \Tests\BaseTestCase
{
    public function testNotRendered()
    {
        $engine = new \Templating\Engine();
        $string = $engine->render('{$defined}{$undefined}',[
            'defined' => ''
        ]);
        $this->assertEquals('{$undefined}',$string);
        // only the {$undefined} is undefined,
        // it should appear in the output
    }

    public function testEmptyValuesNotRender()
    {
        $engine = new \Templating\Engine();
        $o = new stdClass();

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
}