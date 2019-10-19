<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function permission(Request $request)
    {
//        $validatedData = $request->validate([
//            'permission'  => ['required','unique:permissions,name','max:300'],
//            'roleAssignment'  => ['required'],
//        ]);

        /*$permission = new Permission();
        $permission->name = $request->permission;
        $permission->guard_name = "web";
        $permission->syncRoles()

        if()
        {

        }*/
        return $request->all();
    }
}
