<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;

class JobOrderController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['permission:view job orders']);
//    }


    /**
     * Nov. 06, 2019
     * @author john kevin paunel
     * job order view page
     * url: /job-order/orders
     * @return mixed
     * */
    public function jobOrderPage()
    {
        return view('pages.jobOrders.order');
    }

    /**
     * Nov. 06, 2019
     * @author john kevin paunel
     * Add Job Order view page
     * url: /job-order/add-job-order
     * @return mixed
     * */
    public function addJobOrderPage()
    {

        return view('pages.jobOrders.addOrder')->with([
            'categories' => category::all()
        ]);
    }
}
