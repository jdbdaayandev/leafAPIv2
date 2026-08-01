<?php

namespace LeafAPI\Container;



use Closure;


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
     * Resolve dependency
     */
    public function make(string $abstract)
    {

        if(isset($this->instances[$abstract])){
            return $this->instances[$abstract];
        }


        if(isset($this->bindings[$abstract])){

            $object = call_user_func(
                $this->bindings[$abstract]['concrete']
            );


            if($this->bindings[$abstract]['singleton']){
                $this->instances[$abstract]=$object;
            }


            return $object;
        }


        return new $abstract();

    }


}