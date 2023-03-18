<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\APITraits;

class APIcontroller extends Controller
{
    use APITraits;

    public function __construct(){
        $this->middleware('auth:api' , ['except' => ['login' , 'register']]);
    }

    public function login () {
        try{
            $credentials = request(['email' , 'password']);

            $token = Auth::guard('api')->attempt($credentials);


            if(!$token) return $this->returnError(400 , 'something went wrong');

            $user = Auth::guard('api')->user();
            $user->token = $token;

            return $this->returnData(200 , 'test is done' , $user);
        }catch(\Exception $e){
            return $this->returnError(400 , $e->getMessage());
        }
    }

    public function register () {
        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);
    }

    public function logout(Request $request){
        $token = request('token');
        if($token){
            try{
                Auth::guard('api')->setToken($token)->invalidate();
                return $this->returnSuccess(200 , 'logged out successfully');
            }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){ // problem in exception
                return $this->returnError(400 , 'something went wrong');
            }
        }else{
            return $this->returnError(400 , 'something went wrong');
        }
    }
}
