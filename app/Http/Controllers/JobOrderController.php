<?php

namespace App\Http\Controllers;

use App\category;
use App\JobOrder;
use App\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Mixed_;
use Yajra\Datatables\Datatables;

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
     * Nov. 07, 2019
     * @author john kevin paunel
     * Job order datatables to be viewed on job order page
     * */
    public function jobOrdersData()
    {
        $jobOrders = JobOrder::all();


        return Datatables::of($jobOrders)
            ->addColumn('action', function ($jobOrder) {
                return '<a href="#edit-'.$jobOrder->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->editColumn('category_id', function($jobOrder) {
                return category::find($jobOrder->category_id)->name;
            })
            ->editColumn('created_by', function($jobOrder) {
                return User::find($jobOrder->created_by)->username;
            })
            ->make(true);
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

    /**
     * Nov. 07, 2019
     * @author john kevin paunel
     * create job orders
     * @param Request $request
     * @return mixed
     * */
    public function createJobOrder(Request $request)
    {
        $request->validate([
            'title'             => ['required','max:256'],
            'description'       => ['required'],
            'category'          => ['required'],
            'customer_name'     => ['required'],
            'contact_number'    => ['required'],
            'pickup_date'       => ['required','date'],
            'pickup_time'       => ['required'],
        ]);

        $jobOrder = new JobOrder();
        $jobOrder->created_by               = auth()->user()->id;
        $jobOrder->category_id              = $request->category;
        $jobOrder->title                    = $request->title;
        $jobOrder->description              = $request->description;
        $jobOrder->customer_name            = $request->customer_name;
        $jobOrder->customer_contact_number  = $request->contact_number;
        $jobOrder->pickup_date              = $request->pickup_date;
        $jobOrder->pickup_time              = $request->pickup_time;
        $jobOrder->status                   = "pending";

        if($jobOrder->save())
        {
            $result = back()->with('success',true);
        }else{
            $result = back()->with('success',false);
        }
        return $result;
    }
}
