<?php

namespace LeafAPI\Middleware;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;


class RequestHandler implements RequestHandlerInterface
{

    protected $callback;


    public function __construct(
        callable $callback
    )
    {
        $this->callback = $callback;
    }



    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface
    {

        return call_user_func(
            $this->callback,
            $request
        );

    }

}