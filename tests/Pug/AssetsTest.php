<?php

namespace Pug\Tests;

use PHPUnit\Framework\TestCase;
use Pug\Assets;
use Pug\Pug;

class AssetsTest extends TestCase
{
    public function testFacade()
    {
        $pug = new Pug([
            'assetDirectory'  => __DIR__ . '/../project/assets',
            'outputDirectory' => __DIR__ . '/../project/web',
        ]);
        $template = "minify app\n" .
            "  link(rel='stylesheet' href='test.styl')\n" .
            ":coffee-script\n" .
            "  alert 'foo'\n";

        Assets::enable($pug);
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<link rel="stylesheet" href="css/app.min.css">' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );

        Assets::disable($pug);
        $html = trim(str_replace(["\r", "\n"], '', $pug->render($template)));

        self::assertSame(
            '<minify>app<link rel="stylesheet" href="test.styl"></minify>' .
            '<script type="text/javascript">alert(\'foo\');</script>',
            $html
        );

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

    public function testInstance()
    {
    }
}
