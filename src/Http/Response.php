<?php

namespace LeafAPI\Http;

class Response
{


    protected mixed $content;


    protected int $status;



    public function __construct(
        mixed $content = '',
        int $status = 200
    )
    {
        $this->content=$content;

        $this->status=$status;
    }



    public function send(): void
    {

        http_response_code($this->status);


        echo $this->content;

    }


}