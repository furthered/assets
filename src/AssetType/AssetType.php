<?php

namespace Assets\AssetType;

use Illuminate\Support\Collection;

abstract class AssetType {

    protected $paths;

    protected $lib = [];

    public function __construct()
    {
        $this->reset();

        $this->addLib();
        $this->addDefaults();
    }

    abstract protected function getDir();

    abstract protected function getExtension();

    abstract protected function getMainFile();

    abstract protected function wrapInTag($path);

    protected function addDefaults() {}

    public function reset()
    {
        $this->paths = new Collection();
    }

    public function add($paths)
    {
        $this->paths = $this->paths->merge($this->toArray($paths));

        return $this;
    }

    public function remove($paths)
    {
        $this->paths = $this->paths->diff($this->toArray($paths));

        return $this;
    }

    public function output()
    {
        $output = [];

        foreach ($this->paths as $path) {
            if ($this->isLib($path)) {
                $path = $this->lib[$path];
            }

            if (!ends_with($path, $this->getExtension())) {
                $path = $this->getDynamicPath($path);
            }

            $output[] = $this->wrapInTag($path);
        }

        return implode("\n", $output);
    }

    protected function getDynamicPath($path)
    {
        $path = explode('/', $path);
        $path = array_filter($path);

        if (reset($path) != $this->getDir()) {
            array_unshift($path, $this->getDir());
        }

        $path[] = $this->getMainFile();

        return '/' . implode('/', $path);
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
