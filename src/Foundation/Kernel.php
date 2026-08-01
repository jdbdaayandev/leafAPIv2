<?php

namespace LeafAPI\Foundation;


use LeafAPI\Http\Request;
use LeafAPI\Http\Response;


class Kernel
{

    protected Application $app;


    protected array $middleware = [];



    public function __construct(Application $app)
    {
        $this->app = $app;
    }



    /**
     * Handle incoming request
     */
    public function handle(Request $request): Response
    {

        /**
         * Temporary response
         * Router will replace this later
         */
        return new Response(
            "LeafAPI Kernel Running"
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