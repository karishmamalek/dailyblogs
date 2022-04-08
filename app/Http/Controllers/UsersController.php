<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //Register User
    public function register(Request $request){
      $input =  $request->all();
      $input['password'] = bcrypt($input['password']);
      $user = User::create($input);
      $success['name'] = $user->name; 
    }
}
