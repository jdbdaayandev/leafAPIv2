<?php

namespace LeafAPI\Routing;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


use LeafAPI\Http\Psr7\Response;
use LeafAPI\Http\Psr7\Stream;



class Router
{

    protected RouteCollection $routes;


    protected Dispatcher $dispatcher;


    /**
     * Current route prefix
     */
    protected string $prefix = "";



    public function __construct(
        RouteCollection $routes,
        Dispatcher $dispatcher
    )
    {
        $this->routes = $routes;

        $this->dispatcher = $dispatcher;
    }




    /**
     * Register GET route
     */
    public function get(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "GET",
            $uri,
            $action
        );

    }




    /**
     * Register POST route
     */
    public function post(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "POST",
            $uri,
            $action
        );

    }




    /**
     * Register PUT route
     */
    public function put(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "PUT",
            $uri,
            $action
        );

    }




    /**
     * Register PATCH route
     */
    public function patch(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "PATCH",
            $uri,
            $action
        );

    }




    /**
     * Register DELETE route
     */
    public function delete(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "DELETE",
            $uri,
            $action
        );

    }




    /**
     * Register OPTIONS route
     */
    public function options(
        string $uri,
        mixed $action
    ): Route
    {

        return $this->addRoute(
            "OPTIONS",
            $uri,
            $action
        );

    }





    /**
     * Create route
     */
    protected function addRoute(
        string $method,
        string $uri,
        mixed $action
    ): Route
    {


        /*
        |--------------------------------------------------------------------------
        | Apply Prefix
        |--------------------------------------------------------------------------
        */

        $uri =
            $this->prefix . $uri;



        /*
        |--------------------------------------------------------------------------
        | Create Route
        |--------------------------------------------------------------------------
        */

        $route =
            new Route(
                $method,
                $uri,
                $action
            );



        /*
        |--------------------------------------------------------------------------
        | Store Route
        |--------------------------------------------------------------------------
        */

        $this->routes->add(
            $route
        );



        return $route;

    }






    /**
     * Set route prefix
     *
     * Example:
     *
     * Route::prefix('/api/v1')
     */
    public function prefix(
        string $prefix
    ): static
    {

        $this->prefix =
            rtrim($prefix, "/");


        return $this;

    }







    /**
     * Route group
     *
     * Example:
     *
     * Route::prefix('/api/v1')
     *      ->group(function(){
     *
     *      });
     */
    public function group(
        \Closure $callback
    ): void
    {


        $previousPrefix =
            $this->prefix;



        $callback($this);



        /*
        |--------------------------------------------------------------------------
        | Restore previous prefix
        |--------------------------------------------------------------------------
        */

        $this->prefix =
            $previousPrefix;

    }







    /**
     * Dispatch incoming request
     */
    public function dispatch(
        ServerRequestInterface $request
    ): ResponseInterface
    {


        $method =
            $request->getMethod();



        $uri =
            $request
                ->getUri()
                ->getPath();




        $route =
            $this->routes->match(
                $method,
                $uri
            );




        if(!$route)
        {

            return new Response(

                404,

                new Stream(

                    json_encode([

                        "error"=>true,

                        "message"=>"Route not found"

                    ])

                )

            );

        }





        return $this->dispatcher->dispatch(
            $route
        );

    }


}