<?php

namespace LeafAPI\Routing;


use LeafAPI\Container\Container;



class Dispatcher
{

    protected Container $container;



    public function __construct(
        Container $container
    ) {
        $this->container = $container;
    }




    /**
     * Dispatch route action
     */
    public function dispatch(
        Route $route
    ): mixed {

        $action = $route->action;


        /*
        |--------------------------------------------------------------------------
        | Closure
        |--------------------------------------------------------------------------
        */

        if ($action instanceof \Closure) {

            return call_user_func_array(

                $action,

                $route->parameters

            );

        }




        /*
        |--------------------------------------------------------------------------
        | Controller Method
        |--------------------------------------------------------------------------
        */

        if (is_array($action)) {

            return $this->dispatchController(

                $action,

                $route->parameters

            );

        }




        /*
        |--------------------------------------------------------------------------
        | Controller Class
        |--------------------------------------------------------------------------
        */

        if (is_string($action)) {

            $controller =
                $this->container->make(
                    $action
                );


            return $controller();

        }




        throw new \Exception(
            "Invalid route action"
        );

    }






    /**
     * Dispatch Controller@method
     */
    protected function dispatchController(
        array $action,
        array $parameters = []
    ): mixed {

        [
            $controller,
            $method
        ] = $action;


        $instance =
            $this->container->make(
                $controller
            );


        return call_user_func_array(

            [
                $instance,
                $method
            ],

            array_values($parameters)

        );

    }


}