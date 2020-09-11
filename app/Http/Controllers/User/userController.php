<?php

namespace App\Http\Controllers\User;

use App\User;

use App\Jobs\UserVerifyJob;
use Illuminate\Http\Request;
use App\Mail\UserVerification;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ApiController;

class userController extends ApiController
{

    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        
        
        $user->save();
        dispatch(new UserVerifyJob($user));
        if($rules){
            return $this->ApiResponse('User successfully registered',201);
        }
            
    }
}
