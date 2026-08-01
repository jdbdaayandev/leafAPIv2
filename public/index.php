<?php

require __DIR__.'/../vendor/autoload.php';


$app = require __DIR__.'/../bootstrap/app.php';


$request = new LeafAPI\Http\Request();


$kernel = $app->make(
    LeafAPI\Foundation\Kernel::class
);


$response = $kernel->handle($request);


$response->send();