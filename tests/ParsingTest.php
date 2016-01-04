<?php

class ParsingTest extends \Tests\BaseTestCase
{

    public function testRegex()
    {
        $template = 'here is a {function()} template: {$var1} and {$var2} let\'s see {include file=header} and some $var';
        $parser = new \Templating\TemplateParser();
        $this->assertEquals([
            '{$var1}',
            '{$var2}',
        ], $parser->parseVars($template));
        $this->assertEquals([
            '$var1',
            '$var2',
            '$var',
        ], $parser->parseOldVars($template));
        $this->assertEquals([
            '{function()}'
        ],$parser->parseMethods($template));
        $this->assertEquals([
            '{include file=header}'
        ],$parser->parseFlow($template));
    }

    public function testReplace()
    {
        $parser = new \Templating\TemplateParser();

        $values = [
            'first' => 12,
            'second' => 'hello',
        ];

        $template = 'template with {$first} and {$second}';
        $replaced = 'template with 12 and hello';

        $this->assertEquals($replaced,$parser->replaceVars($template,$values));

    }

    public function testRendersOldVars()
    {
        $template = 'template with old $var way';
        $values = [
            'var' => 'text',
        ];
        $loader = new \Storage\FileLoader(__DIR__."/templates","php");
        $renderer = new \Templating\PhpTemplatesRenderer($loader);

    }

}