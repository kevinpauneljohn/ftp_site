<?php

namespace App\Http\Controllers;

use App\JobOrder;
use App\task;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\DataTables;

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
                return '<a href="'.route("job.order.profile",["jobOrderId" => $task->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> View</a>';
            })
            ->editColumn('job_order_id', function($task) {
                $jobOrderLink = '<a href="'.route("job.order.profile",["jobOrderId" => $task->job_order_id]).'">'.JobOrder::find($task->job_order_id)->title.'</a>';
                return $jobOrderLink;
            })
            ->rawColumns(['action', 'job_order_id'])
            ->make(true);
    }
}
