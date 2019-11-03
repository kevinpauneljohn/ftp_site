<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AjaxLoginController extends Controller
{
    /**
     * Nov. 03, 2019
     * @author john kevin paunel
     * manual login authentication
     * @param Request $request
     * @return Response
     * */
    public function authenticate(Request $request)
    {
        $validator =Validator::make($request->all(),[
            "accessAccount"     => 'required',
            "password"          => 'required',
        ]);

        if($validator->passes())
        {
            $field = $this->findUsername($request->accessAccount);

            if (Auth::attempt([$field => $request->accessAccount, 'password' => $request->password])) {
                // The user is active, not suspended, and exists.
                return response()->json(["success" => true]);
            }else{
                return response()->json(["success" => false, "error" => "invalid credential"]);
            }

            return response()->json(["success" => false]);
        }

        return response()->json($validator->errors());
    }

    /**
     * Nov. 03, 2019
     * @author john kevin paunel
     * this will check if the access account input is an email or username
     * @param string $account
     * @return string
     * */
    public function findUsername($account)
    {
        $login = $account;

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }
}
