<?php

namespace App\Http\Controllers;

use http\Env\Url;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super admin']);
    }
    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * Add permission and assign to role
     * @param Request $request
     * @return Url
     * */
    public function permission(Request $request)
    {
        $validatedData = $request->validate([
            'permission'  => ['required','unique:permissions,name','max:300'],
            'roleAssignment'  => ['required'],
        ]);

        $permission = new Permission();
        $permission->name = $request->permission;
        $permission->guard_name = "web";
        foreach($request->roleAssignment as $roles){
            $permission->assignRole($roles);
        }

        if($permission->save())
        {
            $result = back()->with('permissionSuccess',true);
        }else{
            $result = back()->with('permissionSuccess',false);
        }
        return $result;
    }
}
