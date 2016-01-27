<?php

namespace Assets\Tests\AssetType;

use Assets\Tests\TestBase;

class JSTest extends TestBase
{
    /** @test */
    public function it_can_output_basic_js_tags()
    {
        $assets = $this->getAssets();

        $assets->js()->add('something.js');
        $assets->js()->add(['something-else.js']);
        $assets->js()->add(['http://example.com/web.js', 'https://example.com/secure-web.js']);
        $assets->js()->add('js-lib');
        $assets->js()->add('some-main-js');

        $result = [
            '<script type="text/javascript" src="/default-file.js"></script>',
            '<script type="text/javascript" src="/something.js"></script>',
            '<script type="text/javascript" src="/something-else.js"></script>',
            '<script type="text/javascript" src="http://example.com/web.js"></script>',
            '<script type="text/javascript" src="https://example.com/secure-web.js"></script>',
            '<script type="text/javascript" src="/lib-file.js"></script>',
            '<script type="text/javascript" src="/js/apps/some-main-js/app.js"></script>',
        ];

        $this->assertSame(implode("\n", $result), $assets->js()->output());
    }

    /** @test */
    public function it_can_output_inline_js()
    {
        $assets = $this->getAssets();

        $assets->js()->inline('var what = "ok";');

        $result = [
            '<script type="text/javascript" src="/default-file.js"></script>',
            '<script type="text/javascript">var what = "ok";</script>',
        ];

        $this->assertSame(implode("\n", $result), $assets->js()->output());
    }

    /** @test */
    public function it_can_get_a_revision_js_file_if_it_exists()
    {
        $this->putRevisions([
            'default-file.js'             => 'rev1-default-file.js',
            'something.js'                => 'rev2-something.js',
            'lib-file.js'                 => 'rev4-lib-file.js',
            'js/apps/some-main-js/app.js' => 'https://example.com/js/some-main-js/rev5-main.js',
        ]);

        $assets = $this->getAssets();

        $assets->js()->add('something.js');
        $assets->js()->add(['something-else.js']);
        $assets->js()->add('js-lib');
        $assets->js()->add('some-main-js');

        $result = [
            '<script type="text/javascript" src="/build/rev1-default-file.js"></script>',
            '<script type="text/javascript" src="/build/rev2-something.js"></script>',
            '<script type="text/javascript" src="/something-else.js"></script>',
            '<script type="text/javascript" src="/build/rev4-lib-file.js"></script>',
            '<script type="text/javascript" src="https://example.com/js/some-main-js/rev5-main.js"></script>',
        ];

        $this->assertSame(implode("\n", $result), $assets->js()->output());
    }

    /** @test */
    public function it_can_reset_the_js()
    {
        $assets = $this->getAssets();

        $assets->js()->add('something.js');
        $assets->js()->add(['something-else.js']);
        $assets->js()->reset();
        $assets->js()->add('js-lib');
        $assets->js()->add('some-main-js');

        $result = [
            '<script type="text/javascript" src="/lib-file.js"></script>',
            '<script type="text/javascript" src="/js/apps/some-main-js/app.js"></script>',
        ];

        $this->assertSame(implode("\n", $result), $assets->js()->output());
    }

    /** @test */
    public function it_can_remove_js()
    {
        $assets = $this->getAssets();

        $assets->js()->add('something.js');
        $assets->js()->add(['something-else.js']);
        $assets->js()->add('js-lib');
        $assets->js()->add('some-main-js');

        $assets->js()->remove('js-lib');

        $result = [
            '<script type="text/javascript" src="/default-file.js"></script>',
            '<script type="text/javascript" src="/something.js"></script>',
            '<script type="text/javascript" src="/something-else.js"></script>',
            '<script type="text/javascript" src="/js/apps/some-main-js/app.js"></script>',
        ];

        $this->assertSame(implode("\n", $result), $assets->js()->output());
    }
}
