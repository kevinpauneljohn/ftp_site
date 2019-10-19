<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * Dashboard view
     * @return mixed
     * */
    public function dashboard()
    {
        return view('pages.dashboard');
    }
}
