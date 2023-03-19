<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class fawryController extends Controller
{
    public function index(){
        $merchantCode = '1tSa6uxz2nRbgY+b+cZGyA==';
        $merchantRefNum = '2312465464';
        $returnUrl = 'https://developer.fawrystaging.com';
        $itemId = '6b5fdea340e31b3b0339d4d4ae5';
        $quantity = '2';
        $Price = '50.00';
        $SecureHashKey = ''; // need account
        $signature = hash('sha256', $merchantCode . $merchantRefNum . $returnUrl . $itemId . $quantity . $Price);
        try{
            $response = Http::post('https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init' , [
                'merchantCode'=> $merchantCode,
                'merchantRefNum'=> $merchantRefNum,
                'language'=> "en-gb",
                'chargeItems'=> [
                        [
                            'itemId'=> $itemId,
                            'price'=> $Price,
                            'quantity'=> $quantity,
                        ],
                ],
                'paymentMethod'=> 'PayAtFawry',
                'returnUrl'=> $returnUrl,
                'signature'=> $signature,
            ]);
            return response()->json(['msg' => $response->object()]);
        }catch (\Exception $e){
            return response()->json(['msg' => 'errrroororr']);
        }
        return response()->json(['msg' => 'success']);
    }
}
/*
"merchantCode +
merchantRefNum +
customerProfileId (if exists, otherwise insert "") +
returnUrl +
itemId +
quantity +
Price (in tow decimal format like ‘10.00’) +
Secure hash key
*/
