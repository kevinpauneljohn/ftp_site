<?php

namespace App\Http\Controllers;

use App\category;
use App\Events\JobOrderEvent;
use App\JobOrder;
use App\task;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

class JobOrderController extends Controller
{
    use HasRoles;

    private $date;

    public function __construct()
    {
        $this->date = Carbon::now('Asia/Manila');
        $this->date = date_format($this->date,"Y-m-d");
    }

    /**
     * Nov. 12, 2019
     * @author john kevin paunel
     * get total priority job orders
     * @return int
     * */
    public function countAllPriority()
    {
        $jobOrders = JobOrder::where([
            ["status","!=","completed"]
        ])->get();
        $priority = 0;

        foreach ($jobOrders as $jobOrder){
            $date = Carbon::parse($jobOrder->pickup_date);
            $now = Carbon::now('Asia/Manila');

            $diff = $date->diffInDays($now);

            if($diff <= 1)
            {
                $priority = $priority + 1;
            }
        }
        return $priority;
    }

    /**
     * Nov. 06, 2019
     * @author john kevin paunel
     * job order view page
     * url: /job-order/orders
     * @return mixed
     * */
    public function jobOrderPage()
    {

        $totalCompleted = JobOrder::where("status","completed")->count();
        $totalPending = JobOrder::where("status","pending")->count();
        $totalForPickup = JobOrder::where("status","for-pickup")->count();

        return view('pages.jobOrders.order')->with([
            'pending'   => $totalPending,
            'completed' => $totalCompleted,
            'priority'  => $this->countAllPriority(),
            'forPickup' => $totalForPickup
        ]);
    }
    /**
     * Nov. 10, 2019
     * @author john kevin paunel
     * set the status session for all job orders display
     * @param Request $request
     * @return void
     * */
    public function setSession(Request $request)
    {
        if($request->status !== 'all')
        {
            Session::put('statusJobOrder', $request->status);
        }
        else{
            $request->session()->forget('statusJobOrder');
        }
    }

    /**
     * Nov. 07, 2019
     * @author john kevin paunel
     * Job order datatables to be viewed on job order page
     * Yajra data tables
     * */
    public function jobOrdersData()
    {
        if(Session::has('statusJobOrder'))
        {
            $query = JobOrder::where("status",Session::get('statusJobOrder'))->get();
        }else{
            $query = JobOrder::all();
        }
        $jobOrders = $query;
        return Datatables::of($jobOrders)
            ->addColumn('task_count', function ($jobOrder) {
                return JobOrder::find($jobOrder->id)->tasks()->count();
            })
            ->addColumn('action', function ($jobOrder) {
                $action = '<a href="'.route("job.order.profile",["jobOrderId" => $jobOrder->id]).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</a>';
                $action .= '<a href="'.route("job.orders.edit",["jobOrderId" => $jobOrder->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                if(auth()->user()->hasAnyRole(['super admin']))
                {
                    $action .= '<a href="#" class="btn btn-xs btn-danger delete-job" data-toggle="modal" data-target="#delete-job-order" id="job-order-'.$jobOrder->id.'"><i class="fa fa-trash"></i> Delete</a>';
                }
                return $action;
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
                $date=date_create($jobOrder->pickup_date);
                return date_format($date,"d/M/Y");
//                return $jobOrder->pickup_date;
            })
            ->editColumn('id', function($jobOrder) {
                return str_pad($jobOrder->id, 5, '0', STR_PAD_LEFT);
            })
            ->setRowClass(function ($jobOrder) {
                $date = Carbon::parse($jobOrder->pickup_date);
                $now = Carbon::now('Asia/Manila');

                $diff = $date->diffInDays($now);

                if($diff <= 1 && $jobOrder->status != "completed")
                {
                    return 'alert-danger';
                }elseif ($diff <= 3 && $diff > 1 && $jobOrder->status != "completed"){
                    return 'alert-warning';
                }elseif($diff <= 7 && $diff > 3 && $jobOrder->status != "completed")
                {
                    return 'alert-info';
                }

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
     * create or update job orders
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
            'pickup_date'       => ['required','date','date_format:Y-m-d','after_or_equal:'.$this->date],
            'pickup_time'       => ['required'],
            'amount'            => ['required','regex:/^\d*(\.\d{2})?$/','min:0','numeric'],
            'down_payment'      => ['numeric','regex:/^\d*(\.\d{2})?$/','min:0','max:'.$request->amount],
        ],[
            'down_payment.max'  => "max value allowed is ".$request->amount
        ]);

        #this will check if the model will be created or updated
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
            return $jobOrder;
            event(new JobOrderEvent($jobOrder));
//            if($request->jobOrderId == null )
//            {
//                $result = redirect(route('job.order.reference.number', ['jobOrderId' => $jobOrder->id]));
//            }else{
//                $result = back()->with('success',true);
//            }

        }else{
            $result = back()->with('success',false);
        }
        //return $result;

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
     * Nov. 12, 2019
     * @author john kevin paunel
     * display all job order tasks
     * @param int $jobOrderId
     * */
    public function jobOrderProfileTasks($jobOrderId)
    {
        $tasks = JobOrder::find($jobOrderId)->tasks;

        return Datatables::of($tasks)

            ->addColumn('action', function ($task) {
                return '<a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</a>
<a href="'.route("task.page.edit",["taskId" => $task->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
<a class="btn btn-xs btn-danger delete-task-btn" data-toggle="modal" data-target="#delete-task" id="task-'.$task->id.'"><i class="fa fa-trash"></i> Delete</a>';
            })
            ->editColumn('job_order_id', function($task) {

                $jobs = JobOrder::onlyTrashed()
                    ->where('id', $task->job_order_id)
                    ->count();
                if($jobs < 1)
                {
                    $jobOrderLink = '<a href="'.route("job.order.profile",["jobOrderId" => $task->job_order_id]).'">'.ucfirst(JobOrder::find($task->job_order_id)->title).'</a>';
                }else{
                    $jobOrderLink = "";
                }

                return $jobOrderLink;
            })
            ->editColumn('assigned_to', function($task) {
                return User::find($task->assigned_to)->username;
            })
            ->editColumn('status', function($task) {
                $label = new TaskController();
                return $label->taskStatusLabel($task->status);
            })
            ->editColumn('deadline_date', function($task) {
                $date=date_create($task->deadline_date);
                return date_format($date,"d/M/Y");
            })
            ->editColumn('created_at', function($task) {
                $date=date_create($task->created_at);
                return date_format($date,"d/M/Y");
            })
            ->rawColumns(['action', 'job_order_id','status'])
            ->make(true);;
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
        $jobOrders = JobOrder::find($jobOrderId)->tasks;

        if($jobOrders->count() !== 0)
        {
            $tasks = array();

            foreach ($jobOrders as $jobOrder){
                $tasks[$jobOrder->id] = $jobOrder->id;
            }

            $activities = Activity::where([
                ['subject_type','=','App\task'],
                ['subject_id','=',$tasks],
            ])->get();
        }else{
            $activities = 0;
        }


        return view('pages.jobOrders.jobOrderProfile')->with([
            'users'             => User::all(),
            'profile'           => JobOrder::find($jobOrderId),
            'completeButton'    => $this->checkAllTasksStatus($jobOrderId),
            'activities'        => $activities,
        ]);
    }

    /**
     * Nov. 12, 2019
     * @author john kevin paunel
     * @param int $jobOrderId
     * @return boolean
     * */
    public function checkAllTasksStatus($jobOrderId)
    {
        /**
         * count all job order tasks
         * @var $countJobOrderTask
         * */
        $countJobOrderTask = task::where('job_order_id',$jobOrderId)->count();

        /**
         * count all job order tasks completed
         * @var $countTaskCompleted
         * */
        $countTaskCompleted = task::where([
            ['job_order_id','=',$jobOrderId],
            ['status','=','completed'],
        ])->count();


            return $countJobOrderTask == $countTaskCompleted ? true : false;
    }

    public function markComplete(Request $request)
    {
        $tasks = new TaskController();
        $tasks->checkAllTask($request->jobProfileId, "completed");
        return back()->with(["success" => true]);
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
            case 'for-pickup':
                return '<small class="label label-info">'.$status.'</small>';
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
     * route: job.orders.edit
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

    /**
     * Nov. 11, 2019
     * @author john kevin paunel
     * soft delete job order
     * route: job.orders.delete
     * @param Request $request
     * @return Response
     * */
    public function deleteJobOrder(Request $request)
    {
        $jobOrder = JobOrder::find($request->jobOrderId);
        $jobOrder->delete();

        /*soft delete task related as well*/
        $tasks = task::where('job_order_id',$request->jobOrderId)->get();
        foreach ($tasks as $task){
            task::find($task->id)->delete();
        }

        return response()->json(["success" => true]);
    }

    /**
     * Nov. 11, 2019
     * @author john kevin paunel
     * retrieve job order data
     * @param Request $request
     * route: job.orders.display.data
     * @return object
     * */
    public function displayJobOrderData(Request $request)
    {
        $jobOrderId = explode("job-order-",$request->id);

        return JobOrder::find($jobOrderId[1]);
    }

    /**
     * Nov. 13, 2019
     * @author john kevin paunel
     * print job order
     * @param int $jobOrderId
     * @return mixed
     * */
    public function print($jobOrderId)
    {
        return view('pages.jobOrders.invoice')->with([
            'jobOrder'  => $jobOrderId,
            'profile'   => JobOrder::find($jobOrderId)
        ]);
    }

}
