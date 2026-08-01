<?php


use LeafAPI\Foundation\Application;

$app = new Application();


require __DIR__.'/../routes/api.php';


return $app;