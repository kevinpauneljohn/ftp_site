<?php

namespace App\Http\Controllers;

use App\category;
use App\JobOrder;
use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class JobOrderController extends Controller
{

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
     * Yajra data tables
     * */
    public function jobOrdersData()
    {
        $jobOrders = JobOrder::all();

        return Datatables::of($jobOrders)
            ->addColumn('task_count', function ($jobOrder) {
                return JobOrder::find($jobOrder->id)->tasks()->count();
            })
            ->addColumn('action', function ($jobOrder) {
                return '<a href="'.route("job.order.profile",["jobOrderId" => $jobOrder->id]).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</a>
<a href="'.route("job.orders.edit",["jobOrderId" => $jobOrder->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
<a href="'.route("job.order.profile",["jobOrderId" => $jobOrder->id]).'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
            })
            ->editColumn('category_id', function($jobOrder) {
                return category::find($jobOrder->category_id)->name;
            })
            ->editColumn('created_by', function($jobOrder) {
                return User::find($jobOrder->created_by)->username;
            })
            ->editColumn('status', function($jobOrder) {
                return $this->taskStatusLabel($jobOrder->status);
            })
            ->editColumn('created_at', function($jobOrder) {
                $date=date_create($jobOrder->created_at);
                return date_format($date,"d/M/Y h:i:s");
            })
            ->editColumn('pickup_date', function($jobOrder) {
                $date=date_create($jobOrder->deadline_date);
                return date_format($date,"d/M/Y");
            })
            ->editColumn('id', function($jobOrder) {
                return str_pad($jobOrder->id, 5, '0', STR_PAD_LEFT);
            })
            ->rawColumns(['action','status'])
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
            'amount'            => ['required','regex:/^\d*(\.\d{2})?$/','min:0','numeric'],
            'down_payment'      => ['numeric','regex:/^\d*(\.\d{2})?$/','min:0','max:'.$request->amount],
        ],[
            'down_payment.max'  => "max value allowed is ".$request->amount
        ]);

        $jobOrder = ($request->jobOrderId == null ) ? new JobOrder() : JobOrder::find($request->jobOrderId);
        $jobOrder->created_by               = auth()->user()->id;
        $jobOrder->category_id              = $request->category;
        $jobOrder->title                    = $request->title;
        $jobOrder->description              = $request->description;
        $jobOrder->customer_name            = $request->customer_name;
        $jobOrder->customer_contact_number  = $request->contact_number;
        $jobOrder->pickup_date              = $request->pickup_date;
        $jobOrder->pickup_time              = $request->pickup_time;
        $jobOrder->status                   = "pending";
        $jobOrder->amount                   = $request->amount;
        $jobOrder->down_payment             = $request->down_payment;

        if($jobOrder->save())
        {
            if($request->jobOrderId == null )
            {
                $result = redirect(route('job.order.reference.number', ['jobOrderId' => $jobOrder->id]));
            }else{
                $result = back()->with('success',true);
            }

        }else{
            $result = back()->with('success',false);
        }
        return $result;

    }

    /**
     * Nov. 09, 2019
     * @author john kevin paunel
     * redirect page after add job order submitted
     * @param int $jobOrderId
     * @return mixed
     * */
    public function referenceNumber($jobOrderId)
    {
        return view('pages.jobOrders.jobOrderNumber')->with([
            'referenceNumber'   => $jobOrderId
        ]);
    }


    /**
     * Nov. 07, 2019
     * @author john kevin paunel
     * Job Order Profile Page
     * url: /job-order/profile/{$jobOrderId}
     * @param int $jobOrderId
     * @return mixed
     * */
    public function jobOrderProfile($jobOrderId)
    {
        return view('pages.jobOrders.jobOrderProfile')->with([
            'users'         => User::all(),
            'profile'       => JobOrder::find($jobOrderId),
        ]);
    }

    /**
     * Nov. 09, 2019
     * @author john kevin paunel
     * callback method for status label
     * @param int $status
     * @return string
     * */
    public function taskStatusLabel($status)
    {
        switch ($status) {
            case 'pending':
                return '<small class="label label-warning">'.$status.'</small>';
                break;
            case 'completed':
                return '<small class="label label-success">'.$status.'</small>';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * Nov. 11, 2019
     * @author john kevin paunel
     * edit job order page
     * @param int $jobOrderId
     * @return mixed
     * */
    public function editJobOrderPage($jobOrderId)
    {
        return view('pages.jobOrders.editOrder')->with([
            'jobOrder'   => JobOrder::find($jobOrderId),
            'categories' => category::all()
        ]);
    }

}
