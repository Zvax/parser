<?php

class ParsingTest extends \Tests\BaseTestCase
{

    private function parse($string, $regex)
    {
        $matches = [];
        preg_match_all($regex,$string,$matches);
        return $matches;
    }

    public function testRegex()
    {
        $template = '
            here is a {function()} template:
            {$var1} and {$var2}
            let\'s see {include file=header}
            and some $var
            and some {zString}
            and some {$object->property}
        ';

        $this->assertEquals([
            [
                '{$var1}',
                '{$var2}',
            ],
        ], $this->parse($template,\Templating\Regexes::VARIABLE_REGEX));
        $this->assertEquals([
            [
                '$var1',
                '$var2',
                '$var',
                '$object',
            ],
        ], $this->parse($template,\Templating\Regexes::OLD_VARIABLE_REGEX));
        $this->assertEquals([
            [
                '{function()}'
            ],
        ], $this->parse($template,\Templating\Regexes::FUNCTION_REGEX));
        $this->assertEquals([
            [
                '{include file=header}'
            ],
        ], $this->parse($template,\Templating\Regexes::FLOW_REGEX));
        $this->assertEquals([
            [
                '{zString}'
            ],
        ], $this->parse($template,\Templating\Regexes::STRING_REGEX));
        $this->assertEquals([
            [
                '{$object->property}'
            ],
            [
                '{$'
            ],
            [
                'object',
            ],
            [
                '->',
            ],
            [
                'property',
            ],
            [
                '}'
            ],
        ], $this->parse($template,\Templating\Regexes::PROPERTY_REGEX));
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

    public function testEngine()
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

        $stringEngine = new \Templating\Engine();
        $object = new stdClass();
        $object->posts = 'post';
        $stringTemplate = '{$posts}';
        $this->assertEquals('post',$stringEngine->render($stringTemplate,$object));
    }

    public function testPropertiesReplace()
    {
        $engine = new \Templating\Engine();
        $post = new stdClass();
        $post->value = 'string';
        $string = $engine->render('{$post->value}',$post);
        $this->assertEquals('string',$string);
        $string = $engine->render('{$post->value}',[
            'post' => $post,
        ]);
        $this->assertEquals('string',$string);
    }

}