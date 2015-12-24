<?php

namespace Assets\AssetType;

use Illuminate\Support\Collection;

abstract class AssetType
{
    protected $paths;

    protected $lib = [];

    protected $revisions = [];

    public function __construct()
    {
        $this->reset();
        $this->addLib();
        $this->addDefaults();
        $this->loadRevisions();
    }

    abstract protected function getDir();

    abstract protected function getExtension();

    abstract protected function getMainFile();

    abstract protected function srcTag($path);

    abstract protected function wrapInTag($content);

    protected function addDefaults()
    {
    }

    protected function loadRevisions()
    {
        $revisions_path = public_path('build/rev-manifest.json');

        if (file_exists($revisions_path)) {
            $this->revisions = json_decode(file_get_contents($revisions_path), true);
        }
    }

    public function reset()
    {
        $this->paths = new Collection();
    }

    public function add($paths)
    {
        $this->paths = $this->paths->merge($this->toArray($paths))->unique();

        return $this;
    }

    public function remove($paths)
    {
        $this->paths = $this->paths->diff($this->toArray($paths));

        return $this;
    }

    public function inline($content)
    {
        $this->paths[] = $this->wrapInTag($content);
    }

    public function output($items = null)
    {
        if ($items === null) {
            $items = $this->paths->toArray();
        } elseif (!is_array($items)) {
            $items = [$items];
        }

        $output = array_map([$this, 'getOutputItem'], $items);

        return implode("\n", $output);
    }

    protected function getOutputItem($path)
    {
        // If it's inline content, simply return it
        if (starts_with($path, '<')) {
            return $path;
        }

        return $this->srcTag($this->getFinalPath($path));
    }

    protected function getFinalPath($path)
    {
        if ($this->isLib($path)) {
            $path = $this->lib[$path];
        }

        if ($this->isFullUrl($path)) {
            return $path;
        }

        if (!$this->hasExtension($path)) {
            return $this->getDynamicPath($path);
        }

        return $this->getVersionedPath($path);
    }

    protected function isFullUrl($path)
    {
        return starts_with($path, ['http://', 'https://']);
    }

    protected function hasExtension($path)
    {
        return ends_with($path, $this->getExtension());
    }

    protected function getDynamicPath($path)
    {
        $path = explode('/', $path);
        $path = array_filter($path);

        if (reset($path) != $this->getDir()) {
            array_unshift($path, $this->getDir());
        }

        $path[] = $this->getMainFile();

        $path = implode('/', $path);

        return $this->getVersionedPath($path);
    }

    protected function getVersionedPath($path)
    {
        $path = ltrim($path, '/');

        if ($version = array_get($this->revisions, $path)) {
            return ($this->isFullUrl($version)) ? $version : '/build/' . $version;
        }

        return '/' . $path;
    }

    protected function isLib($path)
    {
        return array_key_exists($path, $this->lib);
    }

    protected function toArray($var)
    {
        if (is_array($var)) {
            return $var;
        }

        return [$var];
    }
}
