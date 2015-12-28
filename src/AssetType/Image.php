<?php

namespace Assets\AssetType;

use League\Glide\Urls\UrlBuilderFactory;

class Image
{
    public function dynamic($image, $params)
    {
        return $this->getBuilder()->getUrl($this->getPath($image), $this->getAttr($params));
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

        if (!starts_with($base_url, 'http://')) {
            return 'http://image.' . $base_url;
        }

        return str_replace('http://', 'http://image.', $base_url);
    }

    protected function getAttr($params)
    {
        if ($attr = \Config::get('image.' . $params)) {
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
