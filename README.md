# Pug-Assets

Manage your assets and third-party transpiler (less, stylus, coffee, babel, etc.) and allow you to concat and/or minify them in production environment.

## Install
First you need composer if you have'nt yet: https://getcomposer.org/download/

Then in the root directory of your project, open a terminal and enter:
```shell
composer require pug-php/pug-assets
```

Enable the plugin:
```php
use Pug\Pug;

$pug = new Pug();

// The facade syntax:
Assets::enable($pug);
$pug->render('... minify ...'); // here you can use minfiy, assets or concat keywords to wrap your assets

Assets::disable($pug);
$pug->render('... minify ...'); // here minfiy, assets or concat are simple tags again

// Of the instanciation syntax:
$assets = new Assets($pug);
$pug->render('... minify ...'); // here you can use minfiy, assets or concat keywords to wrap your assets

unset($assets);
$pug->render('... minify ...'); // here minfiy, assets or concat are simple tags again
```
For more information about the concat/minify usage, see https://github.com/pug-php/pug-minify#readme

**Pug-Assets** also instal the coffee, stylus and markdown pug filters to use them as inline contents.
