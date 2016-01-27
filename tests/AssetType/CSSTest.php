<?php

namespace Assets\Tests\AssetType;

use Assets\Tests\TestBase;

class CSSTest extends TestBase
{
    /** @test */
    public function it_can_output_basic_css_tags()
    {
        $assets = $this->getAssets();

        $assets->css()->add('something.css');
        $assets->css()->add(['something-else.css']);
        $assets->css()->add(['http://example.com/web.css', 'https://example.com/secure-web.css']);
        $assets->css()->add('css-lib');
        $assets->css()->add('some-main-css');

        $result = [
            '<link rel="stylesheet" href="/default-file.css" />',
            '<link rel="stylesheet" href="/something.css" />',
            '<link rel="stylesheet" href="/something-else.css" />',
            '<link rel="stylesheet" href="http://example.com/web.css" />',
            '<link rel="stylesheet" href="https://example.com/secure-web.css" />',
            '<link rel="stylesheet" href="/lib-file.css" />',
            '<link rel="stylesheet" href="/css/some-main-css/main.css" />',
        ];

        $this->assertSame(implode("\n", $result), $assets->css()->output());
    }

    /** @test */
    public function it_can_output_inline_css()
    {
        $assets = $this->getAssets();

        $assets->css()->inline('#something { color: red; }');

        $result = [
            '<link rel="stylesheet" href="/default-file.css" />',
            '<style type="text/css">#something { color: red; }</style>',
        ];

        $this->assertSame(implode("\n", $result), $assets->css()->output());
    }

    /** @test */
    public function it_can_get_a_revision_css_file_if_it_exists()
    {
        $this->putRevisions([
            'default-file.css'           => 'rev1-default-file.css',
            'something.css'              => 'rev2-something.css',
            'lib-file.css'               => 'rev4-lib-file.css',
            'css/some-main-css/main.css' => 'https://example.com/css/some-main-css/rev5-main.css',
        ]);

        $assets = $this->getAssets();

        $assets->css()->add('something.css');
        $assets->css()->add(['something-else.css']);
        $assets->css()->add('css-lib');
        $assets->css()->add('some-main-css');

        $result = [
            '<link rel="stylesheet" href="/build/rev1-default-file.css" />',
            '<link rel="stylesheet" href="/build/rev2-something.css" />',
            '<link rel="stylesheet" href="/something-else.css" />',
            '<link rel="stylesheet" href="/build/rev4-lib-file.css" />',
            '<link rel="stylesheet" href="https://example.com/css/some-main-css/rev5-main.css" />',
        ];

        $this->assertSame(implode("\n", $result), $assets->css()->output());
    }

    /** @test */
    public function it_can_reset_the_css()
    {
        $assets = $this->getAssets();

        $assets->css()->add('something.css');
        $assets->css()->add(['something-else.css']);
        $assets->css()->reset();
        $assets->css()->add('css-lib');
        $assets->css()->add('some-main-css');

        $result = [
            '<link rel="stylesheet" href="/lib-file.css" />',
            '<link rel="stylesheet" href="/css/some-main-css/main.css" />',
        ];

        $this->assertSame(implode("\n", $result), $assets->css()->output());
    }

    /** @test */
    public function it_can_remove_css()
    {
        $assets = $this->getAssets();

        $assets->css()->add('something.css');
        $assets->css()->add(['something-else.css']);
        $assets->css()->add('css-lib');
        $assets->css()->add('some-main-css');

        $assets->css()->remove('css-lib');

        $result = [
            '<link rel="stylesheet" href="/default-file.css" />',
            '<link rel="stylesheet" href="/something.css" />',
            '<link rel="stylesheet" href="/something-else.css" />',
            '<link rel="stylesheet" href="/css/some-main-css/main.css" />',
        ];

        $this->assertSame(implode("\n", $result), $assets->css()->output());
    }
}
