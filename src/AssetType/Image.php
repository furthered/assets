<?php

namespace Assets\AssetType;

use Illuminate\Config\Repository;
use Illuminate\Support\Str;
use League\Glide\Urls\UrlBuilderFactory;

class Image
{
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function fetch($image, $type, $custom_dimension = null)
    {
        if ($this->isExternalUrl($image)) {
            return $image;
        }

        return $this->getCloudinaryFetchUrl($image, $type, $custom_dimension);
    }

    public function dynamic($image, $params)
    {
        return $this->getBuilder()->getUrl($this->getPath($image), $this->getAttr($params));
    }

    protected function getCloudinaryFetchUrl($image, $type, $custom_dimension = null)
    {
        $cloudinary_url  = $this->config->get('services.cloudinary.fetch_url', '//res.cloudinary.com/furthered/image/fetch/');
        $image_dimension = $custom_dimension ?: $this->config->get('image.cloudinary.' . $type);
        $cdn_image       = config('services.cdn.url') . '/' . trim(parse_url($image, PHP_URL_PATH), '/');

        return $cloudinary_url . $image_dimension . '/' . $cdn_image;
    }

    protected function getBuilder()
    {
        return UrlBuilderFactory::create($this->getBaseUrl(), 'faster-stronger');
    }

    protected function getBaseUrl()
    {
        $base_url = explode('.', url());
        $base_url = array_slice($base_url, -2, 2);
        $base_url = implode('.', $base_url);

        $base_url = str_replace(['https://', 'http://'], '//', $base_url);

        if (!starts_with($base_url, '//')) {
            return '//image.' . $base_url;
        }

        return str_replace('//', '//image.', $base_url);
    }

    protected function getAttr($params)
    {
        if ($attr = $this->config->get('image.' . $params)) {
            return $attr;
        }

        parse_str($params, $attr);

        foreach ($attr as $key => $value) {
            if (is_numeric($value)) {
                $attr[$key] = (int) $value;
            }
        }

        return $attr;
    }

    protected function getPath($full_path)
    {
        $path = parse_url($full_path, PHP_URL_PATH);
        $path = trim($path, '/');
        $path = explode('/', $path);

        if (head($path) === 'images') {
            array_shift($path);
        }

        return implode('/', $path);
    }

    protected function isExternalUrl($image)
    {
        return Str::contains($image, ['http://', 'https://']) &&
            !Str::contains($image, [ 'austin.test','sixmilliondollarsite.com', 'furthered.com', 'lawline.com' ]);
    }
}
