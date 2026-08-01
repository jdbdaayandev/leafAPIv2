<?php

namespace LeafAPI\Routing;


class RouteCollection
{

    protected array $routes = [];



    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }



    public function all(): array
    {
        return $this->routes;
    }




    /**
     * Find matching route
     */
    public function match(
        string $method,
        string $uri
    ): ?Route {


        foreach ($this->routes as $route) {


            /*
            |--------------------------------------------------------------------------
            | Check HTTP Method
            |--------------------------------------------------------------------------
            */

            if (
                $route->method !== strtoupper($method)
            ) {
                continue;
            }



            /*
            |--------------------------------------------------------------------------
            | Convert parameters
            |
            | /users/{id}
            | becomes
            | /users/([^/]+)
            |--------------------------------------------------------------------------
            */

            $pattern = preg_replace(

                '/\{([^\/]+)\}/',

                '([^\/]+)',

                $route->uri

            );



            $pattern = "#^" . $pattern . "$#";




            if (
                preg_match(
                    $pattern,
                    $uri,
                    $matches
                )
            ) {


                array_shift($matches);


                $route->setParameters(
                    $matches
                );



                return $route;

            }

        }



        return null;

    }


}