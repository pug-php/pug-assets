<?php

namespace Pug\Tests;

use Pug\Assets;
use Pug\Pug;

class AssetsTest extends \PHPUnit_Framework_TestCase
{
    private static function cleanUp()
    {
        if (file_exists(__DIR__ . '/../project/web/test.css')) {
            unlink(__DIR__ . '/../project/web/test.css');
        }
        if (file_exists(__DIR__ . '/../project/web/css/app.min.css')) {
            unlink(__DIR__ . '/../project/web/css/app.min.css');
        }
        if (file_exists(__DIR__ . '/../project/web/css')) {
            rmdir(__DIR__ . '/../project/web/css');
        }
    }

    public function testFacade()
    {
        $pug = new Pug([
            'strict'          => true,
            'environment'     => 'development',
            'assetDirectory'  => __DIR__ . '/../project/assets',
            'outputDirectory' => __DIR__ . '/../project/web',
        ]);
        $bis = new Pug([
            'strict'          => true,
            'environment'     => 'development',
            'assetDirectory'  => __DIR__ . '/../project/assets',
            'outputDirectory' => __DIR__ . '/../project/web',
        ]);
        $template = "minify app\n" .
            "  link(rel='stylesheet' href='test.styl')\n" .
            ":coffee-script\n" .
            "  alert 'foo'\n";

        Assets::enable($pug);
        Assets::enable($bis);
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<link rel="stylesheet" href="css/app.min.css">' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );
        self::assertTrue(file_exists(__DIR__ . '/../project/web/css/app.min.css'));
        self::assertSame(
            'p{color:#f00}',
            trim(file_get_contents(__DIR__ . '/../project/web/css/app.min.css'))
        );

        Assets::disable($pug);
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<minify>app<link rel="stylesheet" href="test.styl"></minify>' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );

        $html = trim(str_replace(["\r", "\n"], '', $bis->render($template)));

        self::assertSame(
            '<link rel="stylesheet" href="css/app.min.css">' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );

        self::cleanUp();
    }

    public function testInstance()
    {
        $pug = new Pug([
            'strict'          => true,
            'environment'     => 'development',
            'assetDirectory'  => __DIR__ . '/../project/assets',
            'outputDirectory' => __DIR__ . '/../project/web',
        ]);
        $assets = new Assets($pug);
        $template = "minify app\n" .
            "  link(rel='stylesheet' href='test.styl')\n" .
            ":coffee-script\n" .
            "  alert 'foo'\n";

        $assets->getMinify()->on('pre-write', function ($params) {
            $params->content = str_replace('color', 'background', $params->content);

            return $params;
        });
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<link rel="stylesheet" href="css/app.min.css">' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );
        self::assertTrue(file_exists(__DIR__ . '/../project/web/css/app.min.css'));
        self::assertSame(
            'p{background:#f00}',
            trim(file_get_contents(__DIR__ . '/../project/web/css/app.min.css'))
        );

        unset($assets);
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<minify>app<link rel="stylesheet" href="test.styl"></minify>' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );

        self::cleanUp();
    }

    public function testEnvironnement()
    {
        $pug = new Pug([
            'environment'     => 'development',
            'assetDirectory'  => __DIR__ . '/../project/assets',
            'outputDirectory' => __DIR__ . '/../project/web',
        ]);
        $assets = new Assets($pug);

        $assets->setEnvironment(null);
        self::assertSame('production', $assets->getEnvironment());

        $self = $assets->setEnvironment('development');
        self::assertSame('development', $assets->getEnvironment());
        self::assertSame($assets, $self);
    }
}
