<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobOrderController extends Controller
{
    public function jobOrderPage()
    {
        return view('pages.jobOrders.order');
    }

    public function addJobOrderPage()
    {
        return view('pages.jobOrders.addOrder');
    }
}
