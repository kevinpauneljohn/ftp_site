<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * variable for checking input if username or email
     * @var string
     * */
    protected $username;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /*protected $redirectTo = '/dashboard';*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * this will check if the submitted input is an email or username
     * @return string
     * */
    public function findUsername()
    {
        $login = request()->input('accessAccount');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Oct. 19, 2019
     * @author john kevin paunel
     * this will override the built in method that returns value to username of email
     * @return string
     * */
    public function username()
    {
        return $this->username;
    }

    public function redirectTo()
    {
        foreach (auth()->user()->getRoleNames() as $role)
        {
            if($role === 'customer')
            {
                return '/index';
            }else{
                return '/dashboard';
            }
        }
    }

    /**
     * Oct. 27, 2019
     * @author john kevin paunel
     * @param Request $request
     * @return mixed
     * */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request)?:redirect(route('login'));
    }

}
