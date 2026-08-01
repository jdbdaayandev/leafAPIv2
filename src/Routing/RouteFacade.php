<?php

namespace LeafAPI\Routing;


class RouteFacade
{

    protected static ?Router $router = null;



    public static function setRouter(
        Router $router
    ): void
    {
        self::$router = $router;
    }




    protected static function router(): Router
    {
        if (!self::$router) {

            throw new \RuntimeException(
                "Router has not been initialized."
            );

        }


        return self::$router;
    }





    public static function get(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->get(
            $uri,
            $action
        );
    }





    public static function post(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->post(
            $uri,
            $action
        );
    }





    public static function put(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->put(
            $uri,
            $action
        );
    }





    public static function patch(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->patch(
            $uri,
            $action
        );
    }





    public static function delete(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->delete(
            $uri,
            $action
        );
    }





    public static function options(
        string $uri,
        mixed $action
    ): Route
    {
        return self::router()->options(
            $uri,
            $action
        );
    }





    /**
     * Set route prefix
     *
     * Example:
     *
     * Route::prefix('/api/v1')
     */
    public static function prefix(
        string $prefix
    ): Router
    {
        return self::router()->prefix(
            $prefix
        );
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
    public static function group(
        \Closure $callback
    ): void
    {
        self::router()->group(
            $callback
        );
    }


}