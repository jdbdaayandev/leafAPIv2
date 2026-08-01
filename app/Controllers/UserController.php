<?php

namespace App\Controllers;


use App\Repositories\UserRepository;


class UserController
{


    protected UserRepository $users;



    public function __construct(
        UserRepository $users
    )
    {
        $this->users = $users;
    }




    public function index()
    {

        return response()->json([

            "data"=>$this->users->all()

        ]);

    }




    public function show(
        $id
    )
    {

        return response()->json([

            "data"=>[
                "id"=>$id,
                "name"=>"John"
            ]

        ]);

    }


}