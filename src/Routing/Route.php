<?php

namespace LeafAPI\Routing;


class Route
{

    public string $method;


    public string $uri;


    public mixed $action;


    public ?string $name = null;


    public array $middleware = [];


    public array $parameters = [];


    protected array $parameterNames = [];




    public function __construct(
        string $method,
        string $uri,
        mixed $action
    )
    {

        $this->method =
            strtoupper($method);


        $this->uri =
            $uri;


        $this->action =
            $action;


        $this->parameterNames =
            $this->extractParameters();

    }




    /**
     * Extract {id} from URI
     */
    protected function extractParameters(): array
    {

        preg_match_all(

            '/\{([^}]+)\}/',

            $this->uri,

            $matches

        );


        return $matches[1] ?? [];

    }





    /**
     * Set matched parameters
     */
    public function setParameters(
        array $values
    ): void
    {

        $this->parameters =
            array_combine(

                $this->parameterNames,

                $values

            ) ?: [];

    }





    public function name(
        string $name
    ): static
    {

        $this->name = $name;

        return $this;

    }




    public function middleware(
        string|array $middleware
    ): static
    {

        $this->middleware =
            array_merge(
                $this->middleware,
                (array)$middleware
            );


        return $this;

    }


}