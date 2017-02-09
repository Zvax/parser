<?php
namespace Tests;
use Templating\Regexes;
class ParsingTest extends \PHPUnit_Framework_TestCase
{
    private function parse($string, $regex)
    {
        $matches = [];
        preg_match_all($regex, $string, $matches);
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
            and some {string}
            and some {$object->property}
        ';
        $this->assertEquals(
            [
                [
                    '{$var1}',
                    '{$var2}',
                ],
                [
                    '{$',
                    '{$',
                ],
                [
                    'var1',
                    'var2',
                ],
                [
                    '}',
                    '}',
                ],
            ],
            $this->parse($template, Regexes::VARIABLE_REGEX)
        );
        $this->assertEquals(
            [
                [
                    '$var1',
                    '$var2',
                    '$var',
                    '$object',
                ],
            ],
            $this->parse($template, Regexes::OLD_VARIABLE_REGEX)
        );
        $this->assertEquals(
            [
                [
                    '{function()}'
                ],
            ],
            $this->parse($template, Regexes::FUNCTION_REGEX)
        );
        $this->assertEquals(
            [
                [
                    '{include file=header}'
                ],
            ],
            $this->parse($template, Regexes::FLOW_REGEX)
        );
        $this->assertEquals(
            [
                [
                    '{zString}',
                    '{string}',
                ],
                [
                    'zString',
                    'string',
                ],
            ],
            $this->parse($template, Regexes::STRING_REGEX)
        );
        $this->assertEquals(
            [
                [
                    '{$object->property}'
                ],
                [
                    'object',
                ],
                [
                    'property',
                ],
            ],
            $this->parse($template, Regexes::PROPERTY_REGEX)
        );
    }
    public function testForeachParsing()
    {
        $template = '{foreach $posts as $post}abc{$post}xyz{/foreach}';
        $expected = [
            [
                '{foreach $posts as $post}abc{$post}xyz{/foreach}',
            ],
            [
                'posts',
            ],
            [
                'post'
            ],
            [
                'abc{$post}xyz'
            ],
        ];
        $this->assertEquals($expected, $this->parse($template, Regexes::FOREACH_REGEX));
    }
}
