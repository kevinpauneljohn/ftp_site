<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware(['role:super admin']);
//    }

    /**
     * Oct. 20, 2019
     * @author john kevin paunel
     * User view
     * @return mixed
     * */
    public function users()
    {
        return view('pages.users')->with([
            'roles'         => Role::all(),
            'users'         => User::all(),
            'permissions'   => Permission::all(),
        ]);
    }

    public function userForm(Request $request)
    {
        $validatedData = $request->validate([
            'firstname'  => ['required'],
            'lastname'  => ['required'],
            'email'  => ['required','email','unique:users,email'],
            'username'  => ['required','unique:users,username'],
            'password'  => ['required','confirmed'],
            'role'  => ['required'],
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->active = 0;
        $user->assignRole($request->role);
        if(!empty($request->permissions))
        {
            foreach ($request->permissions as $permission){
                $user->givePermissionTo($permission);
            }
        }


        if($user->save())
        {
            $result = back()->with('success',true);
        }else{
            $result = back()->with('success',false);
        }

        return $result;
    }

    /**
     * Nov. 24, 2019
     * @author john kevin paunel
     * retrieve user data by ID
     * @param Request $request
     * @return object
     * */
    public function userDetails(Request $request)
    {
        return User::find($request->id)->username;
    }
}
