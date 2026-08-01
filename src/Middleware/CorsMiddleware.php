<?php

namespace App\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;



class CorsMiddleware implements MiddlewareInterface
{


    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {

        $response = $handler->handle(
            $request
        );


        $response = $response->withHeader(
            'Access-Control-Allow-Origin',
            '*'
        );


        return $response;

    }


}