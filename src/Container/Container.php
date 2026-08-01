<?php

namespace LeafAPI\Container;


use Closure;
use ReflectionClass;
use ReflectionParameter;



class Container
{


    protected array $bindings = [];


    protected array $instances = [];



    /**
     * Register singleton
     */
    public function singleton(
        string $abstract,
        Closure $concrete
    ): void
    {

        $this->bindings[$abstract] = [

            'concrete'=>$concrete,

            'singleton'=>true

        ];

    }




    /**
     * Register normal binding
     */
    public function bind(
        string $abstract,
        Closure $concrete
    ): void
    {

        $this->bindings[$abstract] = [

            'concrete'=>$concrete,

            'singleton'=>false

        ];

    }




    /**
     * Resolve dependency
     */
    public function make(
        string $abstract
    ): mixed
    {


        /*
        |--------------------------------------------------------------------------
        | Existing singleton
        |--------------------------------------------------------------------------
        */

        if(isset($this->instances[$abstract]))
        {

            return $this->instances[$abstract];

        }




        /*
        |--------------------------------------------------------------------------
        | Registered binding
        |--------------------------------------------------------------------------
        */

        if(isset($this->bindings[$abstract]))
        {


            $binding =
                $this->bindings[$abstract];


            $object =
                $binding['concrete']($this);



            if($binding['singleton'])
            {

                $this->instances[$abstract] =
                    $object;

            }



            return $object;

        }




        /*
        |--------------------------------------------------------------------------
        | Auto resolve
        |--------------------------------------------------------------------------
        */

        return $this->build(
            $abstract
        );

    }





    /**
     * Automatically create class
     */
    protected function build(
        string $class
    ): object
    {

        $reflection =
            new ReflectionClass(
                $class
            );



        if(!$reflection->isInstantiable())
        {

            throw new \Exception(
                "{$class} cannot be instantiated"
            );

        }




        $constructor =
            $reflection->getConstructor();



        if(!$constructor)
        {

            return new $class();

        }




        $dependencies = [];



        foreach(
            $constructor->getParameters()
            as
            $parameter
        )
        {

            $dependencies[] =
                $this->resolveParameter(
                    $parameter
                );

        }




        return $reflection->newInstanceArgs(
            $dependencies
        );

    }





    /**
     * Resolve constructor parameter
     */
    protected function resolveParameter(
    ReflectionParameter $parameter
): mixed
{

    $type = $parameter->getType();


    /*
    |--------------------------------------------------------------------------
    | Class dependency
    |--------------------------------------------------------------------------
    */

    if(
        $type instanceof \ReflectionNamedType
        &&
        !$type->isBuiltin()
    )
    {

        return $this->make(
            $type->getName()
        );

    }



    /*
    |--------------------------------------------------------------------------
    | Default value
    |--------------------------------------------------------------------------
    */

    if($parameter->isDefaultValueAvailable())
    {

        return $parameter->getDefaultValue();

    }



    /*
    |--------------------------------------------------------------------------
    | Nullable dependency
    |--------------------------------------------------------------------------
    */

    if(
        $type instanceof \ReflectionNamedType
        &&
        $type->allowsNull()
    )
    {

        return null;

    }



    throw new \Exception(
        "Unable to resolve dependency: "
        .$parameter->getName()
    );

}



}