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

        $o->nullValued = null;
        $string = $engine->render('{$this->nullValued}', $o);
        $this->assertEquals('{$this->nullValued}', $string);

        $o->emptyString = "";
        $string = $engine->render('{$this->emptyString}', $o);
        $this->assertEquals('', $string);

    }
}