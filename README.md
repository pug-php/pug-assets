# Pug-Assets
[![Latest Stable Version](https://poser.pugx.org/pug-php/pug-assets/v/stable.png)](https://packagist.org/packages/pug-php/pug-assets)
[![Build Status](https://travis-ci.org/pug-php/pug-assets.svg?branch=master)](https://travis-ci.org/pug-php/pug-assets)
[![StyleCI](https://styleci.io/repos/63942690/shield?style=flat)](https://styleci.io/repos/63942690)
[![Test Coverage](https://codeclimate.com/github/pug-php/pug-assets/badges/coverage.svg)](https://codecov.io/github/pug-php/pug-assets?branch=master)
[![Code Climate](https://codeclimate.com/github/pug-php/pug-assets/badges/gpa.svg)](https://codeclimate.com/github/pug-php/pug-assets)

Manage your assets and third-party transpiler (less, stylus, coffee, babel, etc.) and allow you to concat and/or minify them in production environment.

## Install
First you need composer if you have'nt yet: https://getcomposer.org/download/

Then in the root directory of your project, open a terminal and enter:
```shell
composer require pug-php/pug-assets
```

Enable the plugin:
```php
use Pug\Assets;
use Pug\Pug;

$pug = new Pug();

// The facade syntax:
Assets::enable($pug);
$pug->render('... minify ...'); // here you can use minfiy, assets or concat keywords to wrap your assets

Assets::disable($pug);
$pug->render('... minify ...'); // here minfiy, assets or concat are simple tags again

// Or the instanciation syntax:
$assets = new Assets($pug);
$pug->render('... minify ...'); // here you can use minfiy, assets or concat keywords to wrap your assets

unset($assets);
$pug->render('... minify ...'); // here minfiy, assets or concat are simple tags again
```
For more information about the concat/minify usage, see https://github.com/pug-php/pug-minify#readme

**Pug-Assets** also instal the coffee, react-jsx, stylus, less and markdown pug filters to use them as inline contents.
