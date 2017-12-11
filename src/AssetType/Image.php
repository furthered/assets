<?php

namespace Assets\AssetType;

use Illuminate\Config\Repository;
use League\Glide\Urls\UrlBuilderFactory;

class Image
{
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function fetch($image, $type)
    {
        return $this->getCloudinaryFetchUrl($image, $type);
    }

    public function dynamic($image, $params)
    {
        return $this->getBuilder()->getUrl($this->getPath($image), $this->getAttr($params));
    }

    protected function getCloudinaryFetchUrl($image, $type)
    {
        $cloudinary_url  = $this->config->get('services.cloudinary.fetch_url');
        $image_dimension = $this->config->get('image.cloudinary.' . $type);

        return $cloudinary_url . $image_dimension . '/' . $image;
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
}
