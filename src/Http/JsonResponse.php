<?php

namespace LeafAPI\Http;


class JsonResponse extends Response
{


    public function __construct(
        array $data,
        int $status = 200
    )
    {

        parent::__construct(
            json_encode(
                $data,
                JSON_PRETTY_PRINT
            ),
            $status
        );


        header(
            'Content-Type: application/json'
        );

    }


}