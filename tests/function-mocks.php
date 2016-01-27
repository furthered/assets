<?php

namespace Assets\AssetType;

function public_path($path)
{
    return __DIR__ . '/' . $path;
}

function url()
{
    return 'example.com';
}
