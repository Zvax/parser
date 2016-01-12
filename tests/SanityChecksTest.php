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
}