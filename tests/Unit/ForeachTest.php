<?php declare(strict_types=1);

namespace Zvax\Templating\Tests\Unit;

use PHPUnit\Framework\TestCase;
use stdClass;
use Zvax\Templating\Engine;

class ForeachTest extends TestCase
{
    public function testFlowControl(): void
    {
        $engine = new Engine;
        $string = $engine->render(
            '{foreach $posts as $post}{$post}{/foreach}',
            [
                'posts' => [
                    'post1',
                    'post2',
                ],
            ]
        );
        $this->assertEquals('post1post2', $string);
        $template = '{foreach $posts as $post}<span>{$post->title}</span>{/foreach}';
        $post1 = new stdClass;
        $post2 = new stdClass;
        $post1->title = 'titre1';
        $post2->title = 'titre2';
        $string = $engine->render(
            $template,
            [
                'posts' => [
                    $post1,
                    $post2,
                ],
            ]
        );
        $this->assertEquals('<span>titre1</span><span>titre2</span>', $string);
    }
}
