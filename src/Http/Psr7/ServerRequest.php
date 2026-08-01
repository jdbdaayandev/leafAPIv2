<?php

namespace LeafAPI\Http\Psr7;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;


class ServerRequest implements ServerRequestInterface
{

    protected string $method;

    protected UriInterface $uri;

    protected array $headers = [];

    protected array $attributes = [];

    protected string $protocolVersion = '1.1';

    protected string $body = '';



    public function __construct()
    {

        $this->method =
            $_SERVER['REQUEST_METHOD'] ?? 'GET';


        $this->uri =
            new Uri(
                $_SERVER['REQUEST_URI'] ?? '/'
            );


        $this->body =
            file_get_contents(
                "php://input"
            ) ?: '';



        $this->headers =
            $this->loadHeaders();

    }



    protected function loadHeaders(): array
    {

        $headers = [];


        foreach($_SERVER as $key => $value)
        {

            if(str_starts_with($key, 'HTTP_'))
            {

                $name = strtolower(
                    str_replace(
                        '_',
                        '-',
                        substr($key, 5)
                    )
                );


                $headers[$name] = [
                    $value
                ];

            }

        }


        return $headers;

    }



    public function getRequestTarget(): string
    {
        return $this->uri->getPath();
    }



    public function withRequestTarget(
        $requestTarget
    ): static
    {

        $clone = clone $this;

        $clone->uri =
            new Uri($requestTarget);


        return $clone;

    }



    public function getMethod(): string
    {
        return $this->method;
    }



    public function withMethod(
        $method
    ): static
    {

        $clone = clone $this;

        $clone->method =
            strtoupper($method);


        return $clone;

    }



    public function getUri(): UriInterface
    {
        return $this->uri;
    }



    public function withUri(
        UriInterface $uri,
        bool $preserveHost = false
    ): static
    {

        $clone = clone $this;

        $clone->uri = $uri;


        return $clone;

    }



    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    */


    public function getHeaders(): array
    {
        return $this->headers;
    }



    public function hasHeader(
        $name
    ): bool
    {

        return isset(
            $this->headers[
                strtolower($name)
            ]
        );

    }



    public function getHeader(
        $name
    ): array
    {

        return $this->headers[
            strtolower($name)
        ] ?? [];

    }



    public function getHeaderLine(
        $name
    ): string
    {

        return implode(
            ',',
            $this->getHeader($name)
        );

    }



    public function withHeader(
        $name,
        $value
    ): static
    {

        $clone = clone $this;


        $clone->headers[
            strtolower($name)
        ] = (array)$value;


        return $clone;

    }



    public function withAddedHeader(
        $name,
        $value
    ): static
    {

        $clone = clone $this;


        $key = strtolower($name);


        $existing =
            $clone->headers[$key] ?? [];


        $clone->headers[$key] =
            array_merge(
                $existing,
                (array)$value
            );


        return $clone;

    }



    public function withoutHeader(
        $name
    ): static
    {

        $clone = clone $this;


        unset(
            $clone->headers[
                strtolower($name)
            ]
        );


        return $clone;

    }



    /*
    |--------------------------------------------------------------------------
    | Protocol
    |--------------------------------------------------------------------------
    */


    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }



    public function withProtocolVersion(
        $version
    ): static
    {

        $clone = clone $this;


        $clone->protocolVersion =
            $version;


        return $clone;

    }



    /*
    |--------------------------------------------------------------------------
    | Body
    |--------------------------------------------------------------------------
    */


    public function getBody(): StreamInterface
    {

        return new Stream(
            $this->body
        );

    }



    public function withBody(
        StreamInterface $body
    ): static
    {

        $clone = clone $this;


        $clone->body =
            (string)$body;


        return $clone;

    }



    /*
    |--------------------------------------------------------------------------
    | Server Request
    |--------------------------------------------------------------------------
    */


    public function getServerParams(): array
    {
        return $_SERVER;
    }



    public function getCookieParams(): array
    {
        return $_COOKIE;
    }



    public function withCookieParams(
        array $cookies
    ): static
    {

        $clone = clone $this;


        $_COOKIE = $cookies;


        return $clone;

    }



    public function getQueryParams(): array
    {
        return $_GET;
    }



    public function withQueryParams(
        array $query
    ): static
    {

        $clone = clone $this;


        $_GET = $query;


        return $clone;

    }



    public function getUploadedFiles(): array
    {
        return [];
    }



    public function withUploadedFiles(
        array $uploadedFiles
    ): static
    {

        return clone $this;

    }



    public function getParsedBody(): mixed
    {
        return $_POST;
    }



    public function withParsedBody(
        $data
    ): static
    {

        $clone = clone $this;


        $_POST = $data;


        return $clone;

    }



    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */


    public function getAttributes(): array
    {
        return $this->attributes;
    }



    public function getAttribute(
        $name,
        $default = null
    ): mixed
    {

        return $this->attributes[$name]
            ?? $default;

    }



    public function withAttribute(
        $name,
        $value
    ): static
    {

        $clone = clone $this;


        $clone->attributes[$name] =
            $value;


        return $clone;

    }



    public function withoutAttribute(
        $name
    ): static
    {

        $clone = clone $this;


        unset(
            $clone->attributes[$name]
        );


        return $clone;

    }

}