<?php

namespace LeafAPI\Http\Psr7;


use Psr\Http\Message\StreamInterface;


class Stream implements StreamInterface
{

    protected string $content;


    public function __construct(
        string $content = ''
    )
    {
        $this->content = $content;
    }



    public function __toString(): string
    {
        return $this->content;
    }



    public function getContents(): string
    {
        return $this->content;
    }



    public function close(): void {}

    public function detach()
    {
        return null;
    }


    public function getSize(): ?int
    {
        return strlen($this->content);
    }


    public function tell(): int
    {
        return 0;
    }


    public function eof(): bool
    {
        return true;
    }


    public function isSeekable(): bool
    {
        return false;
    }


    public function seek(
        int $offset,
        int $whence = SEEK_SET
    ): void {}


    public function rewind(): void {}


    public function isWritable(): bool
    {
        return false;
    }


    public function write(
        string $string
    ): int
    {
        return 0;
    }


    public function isReadable(): bool
    {
        return true;
    }


    public function read(
        int $length
    ): string
    {
        return substr(
            $this->content,
            0,
            $length
        );
    }


    public function getMetadata(
        ?string $key = null
    ): mixed
    {
        return null;
    }

}