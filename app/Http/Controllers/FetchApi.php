<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APITraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FetchApi extends Controller
{
    use APITraits;
    public function index(){
        try{
            $response = Http::get('https://mocki.io/v1/d4867d8b-b5d5-4a48-a4ab-79131b5809b8');
            $status = $response->status();
            $state = $response->successful();

            if(!$state) return $this->returnError(400 , 'something went error');
            return $this->returnData(200 , 'success fetching' , $response->object());

        }catch(\Exception $e){
            return $this->returnError(400 , 'something went wrong');
        }
    }
}
