<?php

namespace App\Repositories;


class UserRepository
{

    public function all(): array
    {
        return [
            [
                "id"=>1,
                "name"=>"John"
            ],
            [
                "id"=>2,
                "name"=>"Jane"
            ]
        ];
    }

}