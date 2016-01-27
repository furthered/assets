<?php

namespace Assets\Tests\AssetType;

use Assets\Tests\TestBase;

class ImageTest extends TestBase
{
    /** @test */
    public function it_can_output_an_image_url()
    {
        $config = $this->getConfig();

        $config->shouldReceive('get')->once()->with('image.what=ok')->andReturn(null);

        $assets = $this->getAssets();

        $url = $assets->image()->dynamic('/some/image.jpg', 'what=ok');
        $url = parse_url($url);
        $this->assertSame('http', $url['scheme']);
        $this->assertSame('image.example.com', $url['host']);
        $this->assertSame('/some/image.jpg', $url['path']);
        parse_str($url['query'], $query);
        $this->assertArrayHasKey('what', $query);
        $this->assertSame('ok', $query['what']);
        $this->assertArrayHasKey('s', $query);
        $this->assertNotNull($query['s']);
    }

    /** @test */
    public function it_can_output_a_predefined_config()
    {
        $config = $this->getConfig();

        $config->shouldReceive('get')->once()->with('image.something')->andReturn([
            'hm' => 'fine',
            'so' => 'cool',
        ]);

        $assets = $this->getAssets();

        $url = $assets->image()->dynamic('/some/image.jpg', 'something');
        $url = parse_url($url);
        $this->assertSame('http', $url['scheme']);
        $this->assertSame('image.example.com', $url['host']);
        $this->assertSame('/some/image.jpg', $url['path']);
        parse_str($url['query'], $query);
        $this->assertArrayHasKey('hm', $query);
        $this->assertSame('fine', $query['hm']);
        $this->assertArrayHasKey('so', $query);
        $this->assertSame('cool', $query['so']);
        $this->assertArrayHasKey('s', $query);
        $this->assertNotNull($query['s']);
    }
}
