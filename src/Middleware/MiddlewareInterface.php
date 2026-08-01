<?php

namespace LeafAPI\Middleware;


use LeafAPI\Http\Request;
use LeafAPI\Http\Response;


interface MiddlewareInterface
{

    public function handle(
        Request $request,
        callable $next
    ): Response;


}