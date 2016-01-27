<?php

namespace Assets\Tests;

class AssetsTest extends TestBase
{
    /** @test */
    public function the_properties_are_accessible()
    {
        $assets = $this->getAssets();

        $this->assertInstanceOf('Assets\AssetType\Image', $assets->image());
        $this->assertInstanceOf('Assets\AssetType\CSS', $assets->css());
        $this->assertInstanceOf('Assets\AssetType\JS', $assets->js());
    }
}
