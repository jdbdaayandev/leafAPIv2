<?php

namespace LeafAPI\Http\Psr7;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use LeafAPI\Http\Psr7\Stream;


class Response implements ResponseInterface
{

    protected string $protocolVersion = '1.1';


    protected int $statusCode;


    protected string $reasonPhrase;


    protected array $headers = [];
    


    protected StreamInterface $body;



    public function __construct(
        int $status = 200,
        ?StreamInterface $body = null
    ) {

        $this->statusCode = $status;


        $this->reasonPhrase =
            $this->resolveReasonPhrase($status);


        $this->body =
            $body ?? new Stream('');

    }



    protected function resolveReasonPhrase(
        int $code
    ): string {

        return match ($code) {

            200 => 'OK',

            201 => 'Created',

            204 => 'No Content',

            400 => 'Bad Request',

            401 => 'Unauthorized',

            403 => 'Forbidden',

            404 => 'Not Found',

            422 => 'Unprocessable Entity',

            500 => 'Internal Server Error',

            default => ''

        };

    }



    public function getStatusCode(): int
    {
        return $this->statusCode;
    }



    public function withStatus(
        $code,
        $reasonPhrase = ''
    ): static {

        $clone = clone $this;


        $clone->statusCode = $code;


        $clone->reasonPhrase =
            $reasonPhrase
            ?: $this->resolveReasonPhrase($code);


        return $clone;

    }



    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
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
    ): static {

        $clone = clone $this;


        $clone->protocolVersion = $version;


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
    ): bool {

        return isset(
            $this->headers[
                strtolower($name)
            ]
        );

    }



    public function getHeader(
        $name
    ): array {

        return $this->headers[
            strtolower($name)
        ] ?? [];

    }



    public function getHeaderLine(
        $name
    ): string {

        return implode(
            ',',
            $this->getHeader($name)
        );

    }



    public function withHeader(
        $name,
        $value
    ): static {

        $clone = clone $this;


        $clone->headers[
            strtolower($name)
        ] = (array) $value;


        return $clone;

    }



    public function withAddedHeader(
        $name,
        $value
    ): static {

        $clone = clone $this;


        $key = strtolower($name);


        $clone->headers[$key] =
            array_merge(
                $clone->headers[$key] ?? [],
                (array) $value
            );


        return $clone;

    }



    public function withoutHeader(
        $name
    ): static {

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
    | Body
    |--------------------------------------------------------------------------
    */


    public function getBody(): StreamInterface
    {
        return $this->body;
    }



    public function withBody(
        StreamInterface $body
    ): static {

        $clone = clone $this;


        $clone->body = $body;


        return $clone;

    }



}