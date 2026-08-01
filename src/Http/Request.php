<?php

namespace LeafAPI\Http;


class Request
{

    protected array $query;

    protected array $body;

    protected array $headers;


    public function __construct()
    {
        $this->query = $_GET;

        $this->headers = $this->loadHeaders();

        $this->body = $this->loadBody();
    }



    protected function loadBody(): array
    {

        $contentType = $this->header('Content-Type');


        if(
            str_contains($contentType ?? '', 'application/json')
        ){

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            return $data ?? [];
        }


        return $_POST;
    }



    protected function loadHeaders(): array
    {

        $headers = [];


        foreach($_SERVER as $key=>$value){

            if(str_starts_with($key,'HTTP_')){

                $name = str_replace(
                    '_',
                    '-',
                    strtolower(
                        substr($key,5)
                    )
                );


                $headers[$name]=$value;
            }
        }


        return $headers;
    }



    public function header(string $key, mixed $default=null)
    {

        $key = strtolower($key);


        return $this->headers[$key] ?? $default;
    }



    public function input(
        string $key,
        mixed $default=null
    )
    {
        return $this->body[$key] ?? $default;
    }



    public function all(): array
    {
        return $this->body;
    }



    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }



    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

}