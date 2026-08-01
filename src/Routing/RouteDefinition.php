<?php

namespace LeafAPI\Routing;


class RouteDefinition
{

    public string $method;

    public string $uri;

    public mixed $action;


    public function __construct(
        string $method,
        string $uri,
        mixed $action
    )
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->action = $action;
    }

}