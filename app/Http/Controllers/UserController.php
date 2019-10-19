<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Oct. 20, 2019
     * @author john kevin paunel
     * User view
     * @return mixed
     * */
    public function users()
    {
        return view('pages.users');
    }
}
