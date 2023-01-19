<?php declare(strict_types=1);

namespace Zvax\Templating\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Zvax\Storage\FileLoader;
use Zvax\Templating\Exceptions\InvalidFileException;
use Zvax\Templating\PhpTemplatesRenderer;
use Zvax\Templating\Tests\Constants;
use Zvax\Templating\Tests\ExampleTemplate;
use Zvax\Templating\Tests\ExampleViewObject;
use Zvax\Templating\TwigAdapter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplatingTest extends TestCase
{
    /** @test */
    public function twig_accepts_custom_string_extension_for_loading_templates(): void
    {
        $twig_environment = new Environment(new FilesystemLoader(Constants::TEMPLATES_ROOT));
        $twig_adapter = new TwigAdapter($twig_environment, '.twig');
        $value = $twig_adapter->render('example');
        $this->assertSame('some value', $value);
    }

    public function testCanAccessRendererFromTemplate(): void
    {
        $loader = new FileLoader(Constants::TEMPLATES_ROOT, 'php');
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('accesses_renderer');
        $this->assertEquals('value' . PHP_EOL, $string);
    }

    public function testAccessesValuesFromSubTemplate(): void
    {
        $loader = new FileLoader(Constants::TEMPLATES_ROOT, 'php');
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('accesses_renderer_with_values', [
            'value' => 'value',
        ]);
        $this->assertEquals('value', $string);
    }

    public function testRenders(): void
    {
        $view = new ExampleTemplate;
        $this->assertInstanceOf(ExampleTemplate::class, $view);
        $string = $view->render(sprintf('%s/%s', Constants::TEMPLATES_ROOT, 'test_template.php'));
        $this->assertIsString($string);
    }

    public function testException(): void
    {
        $this->expectException(InvalidFileException::class);
        $view = new ExampleTemplate;
        $view->render('nonfile');
    }

    public function testAcceptsObjectAndRendersIt(): void
    {
        $view = new ExampleViewObject;
        $loader = new FileLoader(Constants::TEMPLATES_ROOT, "php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render('test_template', $view);
        $this->assertIsString($string);
        $this->assertStringContainsString('Example View Object Body Property', $string);
    }

    public function testAcceptsArrayAndRendersValues(): void
    {
        $loader = new FileLoader(Constants::TEMPLATES_ROOT, "php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render(
            'test_template',
            [
                'body' => 'body from array',
            ]
        );
        $this->assertIsString($string);
        $this->assertStringContainsString('body from array', $string);
    }

    public function testRendersFromBasePath(): void
    {
        $loader = new FileLoader(Constants::TEMPLATES_ROOT, "php");
        $renderer = new PhpTemplatesRenderer($loader);
        $string = $renderer->render(
            'test_template',
            [
                'body' => 'whatever',
            ]
        );
        $this->assertIsString($string);
        $this->assertStringContainsString('whatever', $string);
    }
}
