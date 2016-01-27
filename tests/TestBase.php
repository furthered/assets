<?php

namespace Assets\Tests;

require 'function-mocks.php';

use Assets\AssetType\CSS;
use Assets\AssetType\Image;
use Assets\AssetType\JS;
use Assets\Assets;

class TestBase extends \PHPUnit_Framework_TestCase
{
    protected $config;

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = \Mockery::mock('Illuminate\Config\Repository');
        }

        return $this->config;
    }
    protected function getAssets()
    {
        $config = $this->getConfig();

        $config->shouldReceive('get')->once()->with('assets.css.lib', [])->andReturn(['css-lib' => 'lib-file.css']);
        $config->shouldReceive('get')->once()->with('assets.css.defaults', [])->andReturn(['css-default' => 'default-file.css']);
        $config->shouldReceive('get')->once()->with('assets.js.lib', [])->andReturn(['js-lib' => 'lib-file.js']);
        $config->shouldReceive('get')->once()->with('assets.js.defaults', [])->andReturn(['js-default' => 'default-file.js']);
        $config->shouldReceive('get')->once()->with('assets.js.angular_app');

        return new Assets(new CSS($config), new JS($config), new Image($config));
    }

    protected function putRevisions(array $revs)
    {
        file_put_contents(__DIR__ . '/build/rev-manifest.json', json_encode($revs));
    }

    public function tearDown()
    {
        if (file_exists(__DIR__ . '/build/rev-manifest.json')) {
            unlink(__DIR__ . '/build/rev-manifest.json');
        }
    }

    /** @test */
    public function nothing()
    {
    }
}
