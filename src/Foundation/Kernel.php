<?php

namespace LeafAPI\Foundation;


use LeafAPI\Middleware\Pipeline;
use LeafAPI\Middleware\RouteHandler;
use LeafAPI\Routing\Router;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;



class Kernel
{

    protected Application $app;


    protected array $middleware = [];



    public function __construct(
        Application $app
    )
    {
        $this->app = $app;
    }



    /**
     * Handle incoming HTTP request
     */
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface
    {


        $router =
            $this->app->make(
                Router::class
            );



        $pipeline =
            new Pipeline();



        /*
        |--------------------------------------------------------------------------
        | Register Middleware
        |--------------------------------------------------------------------------
        */

        foreach($this->middleware as $middleware)
        {

            $pipeline->add(
                new $middleware()
            );

        }



        /*
        |--------------------------------------------------------------------------
        | Final Request Handler
        |--------------------------------------------------------------------------
        */

        $pipeline->setDestination(

            new RouteHandler(

                function(
                    ServerRequestInterface $request
                ) use ($router)
                {


                    return $router->dispatch(
                        $request
                    );


                }

            )

        );



        return $pipeline->handle(
            $request
        );


    }




    /**
     * Add middleware
     */
    public function middleware(
        string $middleware
    ): void
    {

        $this->middleware[] = $middleware;

    }




    public function getMiddleware(): array
    {
        return $this->middleware;
    }


}