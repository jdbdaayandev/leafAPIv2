<?php


use LeafAPI\Http\JsonResponse;


function response(): object
{
    return new class {

        public function json(
            array $data,
            int $status=200
        ){

            return new JsonResponse(
                $data,
                $status
            );

        }

    };
}