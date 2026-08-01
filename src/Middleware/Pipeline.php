<?php

namespace LeafAPI\Middleware;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;



class Pipeline implements RequestHandlerInterface
{

    protected array $middleware = [];


    protected int $index = 0;


    protected ?RequestHandlerInterface $destination = null;



    public function add(
        MiddlewareInterface $middleware
    ): void
    {
        $this->middleware[] = $middleware;
    }



    public function setDestination(
        RequestHandlerInterface $handler
    ): void
    {
        $this->destination = $handler;
    }



    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface
    {


        if(isset($this->middleware[$this->index]))
        {


            $middleware =
                $this->middleware[$this->index++];


            return $middleware->process(
                $request,
                $this
            );

        }



        if($this->destination)
        {

            return $this->destination->handle(
                $request
            );

        }



        throw new \RuntimeException(
            "No request handler defined"
        );

    }


}