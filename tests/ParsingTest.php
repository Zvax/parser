<?php

class ParsingTest extends \Tests\BaseTestCase
{

    private function parse($string, $regex)
    {
        $matches = [];
        preg_match_all($regex,$string,$matches);
        return $matches[0];
    }

    public function testRegex()
    {
        $template = '
            here is a {function()} template:
            {$var1} and {$var2}
            let\'s see {include file=header}
            and some $var
            and some {zString}
        ';

        $this->assertEquals([
            '{$var1}',
            '{$var2}',
        ], $this->parse($template,\Templating\TemplateParser::VARIABLE_REGEX));
        $this->assertEquals([
            '$var1',
            '$var2',
            '$var',
        ], $this->parse($template,\Templating\TemplateParser::OLD_VARIABLE_REGEX));
        $this->assertEquals([
            '{function()}'
        ], $this->parse($template,\Templating\TemplateParser::FUNCTION_REGEX));
        $this->assertEquals([
            '{include file=header}'
        ], $this->parse($template,\Templating\TemplateParser::FLOW_REGEX));
        $this->assertEquals([
            '{zString}'
        ], $this->parse($template,\Templating\TemplateParser::STRING_REGEX));
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

    public function testHtmlStringRendering()
    {
        $loader = new \Storage\FileLoader(__DIR__."/templates","html");
        $rznKeysRenderer = new \Templating\RznKeysRenderer($loader);
        $values = [
            '{zValue}' => 'replaced',
            '{zSecondValue}' => 'replaced2',
        ];
        $string = $rznKeysRenderer->render('string_template',$values);
        $this->assertEquals('replacedreplaced2',$string);
    }

    public function testPhpTemplateRenderer()
    {
        $loader = new \Storage\FileLoader(
            __DIR__."/templates",
            "tpl"
        );
        $engine = new \Templating\Engine($loader);
        $rendered = $engine->render('template_futur',[
            'posts' => 'post',
            '{zValue}' => 'post',
        ]);
        $this->assertEquals('postpost',$rendered);
    }

}