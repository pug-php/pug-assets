<?php

namespace Pug;

use Jade\Jade;
use Pug\Keyword\Minify;

class Assets
{
    /**
     * @var Pug|Jade
     */
    protected $pug;

    /**
     * @var Minify
     */
    protected $minify;

    /**
     * @var array
     */
    protected static $links;

    /**
     * Assets constructor.
     *
     * @param Pug $pug
     */
    public function __construct(Jade $pug)
    {
        $this->pug = $pug;
        $this->setMinify(new Minify($pug));
    }

    /**
     * @param Pug|Jade $pug
     *
     * @return Assets $assets
     */
    public static function enable(Jade $pug)
    {
        $assets = new static($pug);
        static::$links[] = $assets;

        return $assets;
    }

    /**
     * @param Pug|Jade $pug
     *
     * @return Assets $assets
     */
    public static function disable(Jade $pug)
    {
        $assets = null;
        static::$links = array_filter(static::$links, function ($entry) use (&$assets, $pug) {
            if ($entry->getPug() === $pug) {
                $assets = $entry->unsetMinify();

                return false;
            }

            return true;
        });

        return $assets;
    }

    /**
     * @param string $environment
     *
     * @return self $this
     */
    public function setEnvironment($environment)
    {
        $this->pug->setCustomOption('environment', $environment);

        return $this;
    }

    /**
     * @return string $environment
     */
    public function getEnvironment()
    {
        return $this->pug->getOption('environment') ?: 'production';
    }

    /**
     * @return Minify
     */
    public function getMinify()
    {
        return $this->minify;
    }

    /**
     * @return Jade|Pug
     */
    public function getPug()
    {
        return $this->pug;
    }

    /**
     * @param Minify $minify
     *
     * @return self $this
     */
    public function setMinify($minify)
    {
        $this->pug->setKeyword('assets', $minify);
        $this->pug->setKeyword('concat', $minify);
        $this->pug->setKeyword('concat-to', $minify);
        $this->pug->setKeyword('minify', $minify);
        $this->pug->setKeyword('minify-to', $minify);
        $this->minify = $minify;

        return $this;
    }

    /**
     * Remove the keywords.
     *
     * @return self $this
     */
    public function unsetMinify()
    {
        $this->pug->removeKeyword('assets');
        $this->pug->removeKeyword('concat');
        $this->pug->removeKeyword('concat-to');
        $this->pug->removeKeyword('minify');
        $this->pug->removeKeyword('minify-to');
        $this->minify = null;

        return $this;
    }

    /**
     * Assets destructor.
     */
    public function __destruct()
    {
        $this->unsetMinify();
    }
}
