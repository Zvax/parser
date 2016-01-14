<?php

namespace Tests;

use Storage\FileLoader;
use Templating\Engine;
use Templating\RznKeysRenderer;
use Templating\TemplateParser;
use stdClass;

class EngineTest extends BaseTestCase
{


    public function testReplace()
    {
        $parser = new TemplateParser();

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
        $loader = new FileLoader(__DIR__."/templates","html");
        $rznKeysRenderer = new RznKeysRenderer($loader);
        $values = [
            '{zValue}' => 'replaced',
            '{zSecondValue}' => 'replaced2',
        ];
        $string = $rznKeysRenderer->render('string_template',$values);
        $this->assertEquals('replacedreplaced2',$string);
    }

    public function testEngine()
    {
        $loader = new FileLoader(
            __DIR__."/templates",
            "tpl"
        );
        $engine = new Engine($loader);
        $rendered = $engine->render('template_futur',[
            'posts' => 'post',
            '{zValue}' => 'post',
        ]);
        $this->assertEquals('postpost',$rendered);

        $stringEngine = new Engine();
        $object = new stdClass();
        $object->posts = 'post';
        $stringTemplate = '{$posts}';
        $this->assertEquals('post',$stringEngine->render($stringTemplate,$object));
    }

    public function testPropertiesReplace()
    {
        $engine = new Engine();
        $post = new stdClass();
        $post->value = 'string';
        $string = $engine->render('{$post->value}',$post);
        $this->assertEquals('string',$string);
        $string = $engine->render('{$post->value}',[
            'post' => $post,
        ]);
        $this->assertEquals('string',$string);
    }

    public function testStringReplacement()
    {
        $engine = new Engine();
        $string = $engine->render('{zValue}',[
            '{zValue}' => 'valeur',
        ]);
        $this->assertEquals('valeur', $string);

        $string = $engine->render('{zValue}',[
            'Value' => 'valeur',
        ]);
        $this->assertEquals('valeur', $string);
    }

    public function testFlowControl()
    {
        $template = '{foreach $posts as $post}abc{$post}xyz{/foreach}';
        $engine = new Engine();
        $string = $engine->render($template,[
            'posts' => [
                'one',
                'two',
            ],
        ]);
        $this->assertEquals('onetwo',$string);
    }

}