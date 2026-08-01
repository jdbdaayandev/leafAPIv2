<?php

namespace LeafAPI\Http;


use LeafAPI\Http\JsonResponse;
use LeafAPI\Http\Response;



class ResponseFactory
{


    /**
     * Create JSON response
     */
    public function json(
        array $data,
        int $status = 200
    ): JsonResponse
    {

        return new JsonResponse(
            $data,
            $status
        );

    }




    /**
     * Create normal response
     */
    public function make(
        string $content = "",
        int $status = 200
    ): Response
    {

        return new Response(
            $content,
            $status
        );

    }




    /**
     * Empty response
     */
    public function noContent(): Response
    {

        return new Response(
            "",
            204
        );

    }



}