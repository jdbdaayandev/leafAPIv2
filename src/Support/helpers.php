<?php

use LeafAPI\Http\ResponseFactory;


if (!function_exists('response')) {

    function response(): ResponseFactory
    {
        return new ResponseFactory();
    }

}