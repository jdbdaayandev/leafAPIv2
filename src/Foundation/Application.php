<?php

namespace LeafAPI\Foundation;


use LeafAPI\Container\Container;


class Application extends Container
{

    /**
     * Framework version
     */
    protected string $version = '0.1.0';


    /**
     * Application instance
     */
    protected static ?Application $instance = null;



    public function __construct()
    {
        self::$instance = $this;

        $this->registerBaseBindings();
    }



    /**
     * Register core services
     */
    protected function registerBaseBindings(): void
    {

        $this->singleton(
            Application::class,
            fn() => $this
        );

    }



    /**
     * Get application instance
     */
    public static function getInstance(): ?Application
    {
        return self::$instance;
    }



    public function version(): string
    {
        return $this->version;
    }


}