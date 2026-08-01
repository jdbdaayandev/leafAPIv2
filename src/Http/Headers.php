<?php

namespace LeafAPI\Http;


class Headers
{

    protected array $headers = [];


    public function set(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }


    public function get(string $key, mixed $default = null): mixed
    {
        return $this->headers[$key] ?? $default;
    }


    public function all(): array
    {
        return $this->headers;
    }


}