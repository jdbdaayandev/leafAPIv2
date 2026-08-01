<?php

namespace LeafAPI\Http;


use LeafAPI\Http\Psr7\Response;
use LeafAPI\Http\Psr7\Stream;



class JsonResponse extends Response
{


    public function __construct(
        array $data,
        int $status = 200
    )
    {


        parent::__construct(

            $status,

            new Stream(
                json_encode(
                    $data,
                    JSON_PRETTY_PRINT
                )
            )

        );



        $this->headers['content-type'] = [
            'application/json'
        ];

    }


}