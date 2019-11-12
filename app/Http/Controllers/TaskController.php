<?php

namespace App\Http\Controllers;

use App\JobOrder;
use App\task;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use HasRoles;
    public function __construct()
    {
        $this->middleware('role:super admin|admin|graphic artist|sales');
    }

    /**
     * Nov. 08, 2019
     * @author john kevin paunel
     * url: /task
     * route name: task
     * task view page
     * @return mixed
     * */
    public function taskPage()
    {
        return view('pages.task.task');
    }

    /**
     * Nov. 08, 2019
     * @author john kevin paunel
     * url: /user-task
     * route: task.list
     * user task data table display
     * */
    public function userTask()
    {
        $tasks = User::find(auth()->user()->id)->tasks;
        return Datatables::of($tasks)
            ->addColumn('action', function ($task) {
                $action = '<a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</a>';
                $action .= ' <a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                $action .= (auth()->user()->hasRole('super admin')) ? ' <a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Trash</a>' : '';
                return  $action;
            })
            ->editColumn('job_order_id', function($task) {
                $jobOrderLink = '<a href="'.route("job.order.profile",["jobOrderId" => $task->job_order_id]).'">'.ucfirst(JobOrder::find($task->job_order_id)->title).'</a>';
                return $jobOrderLink;
            })
            ->editColumn('status', function($task) {
                return $this->taskStatusLabel($task->status);
            })
            ->rawColumns(['action', 'job_order_id','status'])
            ->make(true);
    }

    /**
     * Nov. 10, 2019
     * @author john kevin paunel
     * set the status session for all task display
     * @param Request $request
     * @return void
     * */
    public function setSession(Request $request)
    {
        if($request->status !== 'all')
        {
            Session::put('status', $request->status);
        }
        else{
            $request->session()->forget('status');
        }
    }
    /**
     * nov. 10, 2019
     * @author john kevin paunel
     * display all task
     * */
    public function allTaskData(Request $request)
    {
        if(Session::has('status'))
        {
            $query = task::where("status",Session::get('status'))->get();
        }else{
            $query = task::all();
        }
        $tasks = $query;
        return Datatables::of($tasks)

            ->addColumn('action', function ($task) {
                return '<a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</a>
<a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
<a href="'.route("task.profile",["taskId" => $task->id]).'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
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
                return $this->taskStatusLabel($task->status);
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
            ->make(true);
    }

    /**
     * Nov. 08, 2019
     * @author john kevin paunel
     * url: /task/profile/{taskId}
     * route: task.list
     * @param int $taskId
     * @return mixed
     * */
    public function taskProfile($taskId)
    {
        $task = task::find($taskId);
        return view('pages.task.taskProfile')->with([
            'profile'   => $task->jobOrder,
            'task'      => $task,
        ]);
    }

    /**
     * Nov. 08, 2019
     * @author john kevin paunel
     * route: task.status.action
     * @param Request $request
     * @return  Response
     * */
    public function statusAction(Request $request)
    {
        $statusOperation = explode('-',$request->value);

        $status = task::find($statusOperation[1]);
        if($statusOperation[0] == 'start')
        {
            $status->status = 'on-going';
            $status->start_time = Carbon::now();
        }elseif ($statusOperation[0] == 'end'){
            $status->status = 'for-approval';
            $status->end_time = Carbon::now();
        }elseif ($statusOperation[0] == 'completed'){
            $status->status = 'completed';
        }

        if($status->save())
        {
            if($statusOperation[0] == 'completed')
            {
                $this->checkAllTask($status->job_order_id,"for-pickup");
            }

            $result = ['success' => true];
        }else{
            $result = ['success' => false];
        }

        return response()->json($result);
    }

    /**
     * Nov. 11, 2019
     * @author john kevin paunel
     * will update job order status to for pick up if all tasks are completed
     * @param int $jobOrderId
     * @param string $status
     * @return void
     * */
    public function checkAllTask($jobOrderId,$status)
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

        if($countJobOrderTask == $countTaskCompleted)
        {
            $jobOrder = JobOrder::find($jobOrderId);
            $jobOrder->status = $status;
            $jobOrder->save();
        }
    }

    /**
     * Nov. 08, 2019
     * @author john kevin paunel
     * create task callback
     * @param Request $request
     * @return Response
     * */
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'             => 'required',
            'description'       => 'required',
            'deadline_date'     => 'required',
            'deadline_time'     => 'required',
            'assignTo'          => 'required',
        ]);

        if($validator->passes())
        {
            $task = new task();
            $task->job_order_id = $request->job_order_id;
            $task->created_by = $request->created_by;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->deadline_date = $request->deadline_date;
            $task->deadline_time = $request->deadline_time;
            $task->assigned_to = $request->assignTo;
            $task->status = "pending";

            if($task->save())
            {
                $message = ["success" => true];
            }else{
                $message = ["success" => false];
            }

            return response()->json($message);
        }

        return response()->json($validator->errors());
    }


    /**
     * Nov. 09, 2019
     * @author john kevin paunel
     * all task view page
     * route: task.all
     * url: /task/all-task
     * @return mixed
     * */
    public function allTasks()
    {
        return view('pages.task.allTask')->with([
            'status'    => $this,
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
            case 'on-going':
                return '<small class="label label-primary">'.$status.'</small>';
                break;
            case 'for-approval':
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
}
