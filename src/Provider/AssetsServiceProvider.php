<?php

namespace Assets\Provider;

use Assets\Assets;
use Assets\AssetType\CSS;
use Assets\AssetType\Image;
use Assets\AssetType\JS;
use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('assets', function () {
            return app('Assets\Assets');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['assets'];
    }
}
