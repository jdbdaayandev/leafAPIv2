<?php

namespace LeafAPI\Foundation;


use LeafAPI\Container\Container;

use LeafAPI\Routing\Router;
use LeafAPI\Routing\RouteCollection;
use LeafAPI\Routing\RouteFacade;
use LeafAPI\Routing\Dispatcher;

use LeafAPI\Middleware\Pipeline;



class Application extends Container
{


    protected string $version = '0.1.0';


    protected static ?Application $instance = null;



    public function __construct()
    {

        self::$instance = $this;

        $this->registerBaseBindings();

    }




    protected function registerBaseBindings(): void
    {


        /*
        |--------------------------------------------------------------------------
        | Application
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            Application::class,
            fn() => $this
        );




        /*
        |--------------------------------------------------------------------------
        | Route Collection
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            RouteCollection::class,
            fn() => new RouteCollection()
        );




        /*
        |--------------------------------------------------------------------------
        | Dispatcher
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            Dispatcher::class,

            function($app){

                return new Dispatcher(
                    $app
                );

            }

        );




        /*
        |--------------------------------------------------------------------------
        | Router
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            Router::class,

            function($app){

                return new Router(

                    $app->make(
                        RouteCollection::class
                    ),

                    $app->make(
                        Dispatcher::class
                    )

                );

            }

        );




        /*
        |--------------------------------------------------------------------------
        | Route Facade
        |--------------------------------------------------------------------------
        */

        RouteFacade::setRouter(

            $this->make(
                Router::class
            )

        );




        /*
        |--------------------------------------------------------------------------
        | Middleware Pipeline
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            Pipeline::class,

            fn() => new Pipeline()

        );




        /*
        |--------------------------------------------------------------------------
        | Kernel
        |--------------------------------------------------------------------------
        */

        $this->singleton(
            Kernel::class,

            function($app){

                return new Kernel(
                    $app
                );

            }

        );


    }




    public static function getInstance(): ?Application
    {
        return self::$instance;
    }




    public function version(): string
    {
        return $this->version;
    }


}