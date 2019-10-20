<?php

namespace App\Http\Controllers;

use http\Url;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super admin']);
    }
    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * Roles  view
     * @return mixed
     * */
    public function roles()
    {
        return view('pages.roles')->with([
            'roles' => Role::all()
        ]);
    }

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * Add role form validation and store of new role name
     * @param Request $request
     * @return Url
     * */
    public function rolesForm(Request $request)
    {
        $validatedData = $request->validate([
            'roleName'  => ['required','unique:roles,name','max:30'],
        ]);

        $role = new Role();
        $role->name = $request->roleName;
        $role->guard_name = "web";

        if($role->save())
        {
            $result = back()->with('success',true);
        }else{
            $result = back()->with('success',false);
        }

        return $result;
    }
}
