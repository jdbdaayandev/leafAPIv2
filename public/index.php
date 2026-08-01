<?php

require __DIR__.'/../vendor/autoload.php';


$app = require __DIR__.'/../bootstrap/app.php';


$response = response()->json([
    "framework"=>"LeafAPI",
    "version"=>$app->version(),
    "status"=>"running"
]);


$response->send();