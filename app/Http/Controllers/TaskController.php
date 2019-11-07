<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class TaskController extends Controller
{
    use HasRoles;
    public function __construct()
    {
        $this->middleware('role:super admin|admin|graphic artist|sales');
    }

    public function taskPage()
    {
        return view('pages.task.task');
    }
}
