<?php

namespace App\Middleware;


use LeafAPI\Http\Request;
use LeafAPI\Http\Response;
use LeafAPI\Middleware\MiddlewareInterface;


class TestMiddleware implements MiddlewareInterface
{


    public function handle(
        Request $request,
        callable $next
    ): Response
    {

        error_log(
            "Middleware executed"
        );


        return $next($request);

    }


}