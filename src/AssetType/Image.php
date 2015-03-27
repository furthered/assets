<?php

namespace Assets\AssetType;

use League\Glide\Http\UrlBuilderFactory;

class Image {

    public function dynamic($image, $params)
    {
        $url = parse_url($image);

        $path = explode('/', trim($url['path'], '/'));

        if (head($path) == 'images') {
            array_shift($path);
        }

        $path = implode('/', $path);

        parse_str($params, $attr);

        foreach ($attr as $key => $value) {
            if (is_numeric($value)) {
                $attr[$key] = (int) $value;
            }
        }

        $base_url = explode('.', url());
        $base_url = array_slice($base_url, -2, 2);
        $base_url = implode('.', $base_url);

        if (!starts_with($base_url, 'http://')) {
            $base_url = 'http://' . $base_url;
        }

        $image_url = str_replace('http://', 'http://image.', $base_url);

        $url_builder = UrlBuilderFactory::create($image_url, 'faster-stronger');

        return $url_builder->getUrl($path, $attr);
    }

}
