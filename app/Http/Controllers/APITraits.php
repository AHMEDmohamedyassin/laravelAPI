<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

trait APITraits
{
    public function returnSuccess($status = 200 , $msg){
        return response()->json([
            'state' => true ,
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    public function returnError($status = 400 , $msg){
        return response()->json([
            'state' => true ,
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    public function returnData($status = 200 , $msg , $data){
        return response()->json([
            'state' => true ,
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}
