<?php

namespace LeafAPI\Http\Psr7;


use Psr\Http\Message\UriInterface;


class Uri implements UriInterface
{

    protected string $uri;


    public function __construct(
        string $uri
    )
    {
        $this->uri=$uri;
    }



    public function __toString(): string
    {
        return $this->uri;
    }



    public function getScheme(): string
    {
        return parse_url($this->uri, PHP_URL_SCHEME) ?? '';
    }


    public function getHost(): string
    {
        return parse_url($this->uri, PHP_URL_HOST) ?? '';
    }


    public function getPath(): string
    {
        return parse_url($this->uri, PHP_URL_PATH) ?? '/';
    }


    public function getQuery(): string
    {
        return parse_url($this->uri, PHP_URL_QUERY) ?? '';
    }


    public function getAuthority(): string
    {
        return $this->getHost();
    }


    public function getUserInfo(): string
    {
        return '';
    }


    public function getPort(): ?int
    {
        return null;
    }


    public function getFragment(): string
    {
        return '';
    }


    public function withScheme($scheme): static
    {
        return $this;
    }


    public function withUserInfo(
        $user,
        $password=null
    ): static
    {
        return $this;
    }


    public function withHost(
        $host
    ): static
    {
        return $this;
    }


    public function withPort(
        $port
    ): static
    {
        return $this;
    }


    public function withPath(
        $path
    ): static
    {
        return $this;
    }


    public function withQuery(
        $query
    ): static
    {
        return $this;
    }


    public function withFragment(
        $fragment
    ): static
    {
        return $this;
    }

}