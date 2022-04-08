<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Basecontroller as BaseController;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(Request $request){
        print_r($request);
        die();
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error..',$validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->creatToken('My Blog')->plainTextToken;
        $successp['name'] = $user->name;

        return $this->sendResponse($success,'User resgister successfully..');
    }

    /*
    Login API
    */
    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('My Blog')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success,'User Login Successfully');

        }else{
            return $this->sendError('Unauthorised..',['error'=>'Unauthorised']);
        }

    }
}
