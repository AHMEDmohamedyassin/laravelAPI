<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class paymobController extends Controller
{
    public $API = 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRZNE1UTTVMQ0p1WVcxbElqb2lNVFkzT1RBM05UQXdOeTQ1TVRZNU5qY2lmUS5CN2lhTEFxMU9OaUdZenBfa29hcUZMazNhOTNWRU5FNWFsY1VFRG03azBTU0kxZm9Lcm52WllGMHlUdDMwUHd3VHRJNGdsT3RFZWFLVURHM0ExWkNydw==';
    public $IframeID = 370320;
    public $integration_id_mobile = 2179983;
    public $integration_id_card = 1987498;

    public function step1(){
        try{
            $response = Http::post('https://accept.paymob.com/api/auth/tokens',['api_key' => $this->API]);
            $token = $response->object()->token;
            return $this->step2($token);
            // return response()->json(['token' => $token]);
        }catch(\Exception $e){
            return response()->json(['msg' => 'errror']);
        }
    }

    public function step2($token){
        try{
            $response = Http::post('https://accept.paymob.com/api/ecommerce/orders' , [
                "auth_token" =>  $token,
                "delivery_needed"=> "false",
                "amount_cents" => "100",
                "currency" => "EGP",
                "items" =>[],
            ]);
            $id = $response->object()->id;
            return $this->step3($id , $token);
            // return response()->json(['id' => $id]);
        }catch(\Exception $e){
            return response()->json(['msg' => 'errrrror']);
        }
    }

    public function step3($id , $token){
        try{
            $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys' , [
                "auth_token" => $token,
                "amount_cents" => "100",
                "expiration" => 3600,
                "order_id" => $id,
                "billing_data" =>  [
                    "apartment" => "803",
                    "email" => "claudette09@exa.com",
                    "floor" => "42",
                    "first_name" => "Clifford",
                    "street" => "Ethan Land",
                    "building" => "8028",
                    "phone_number" => "+201010101010",
                    "shipping_method" => "PKG",
                    "postal_code" => "01898",
                    "city" => "Jaskolskiburgh",
                    "country" => "CR",
                    "last_name" => "Nicolas",
                    "state" => "Utah"
                ],
                "currency" => "EGP",
                // "integration_id" =>  $this->integration_id_mobile,
                "integration_id" =>  $this->integration_id_card,
                "lock_order_when_paid" => "false",
            ]);
            $newToken = $response->object()->token;
            // return $this->mobileWallet($newToken);    // activate for mobile wallet
            return response()->json(['msg' => "https://accept.paymobsolutions.com/api/acceptance/iframes/{$this->IframeID}?payment_token={$newToken}"]);
        }catch(\Exception $e ){
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function mobileWallet($token){
        try{
            $response = Http::post('https://accept.paymob.com/api/acceptance/payments/pay' , [
                "source" => [
                    "identifier" => "+201010101010",
                    "subtype" => "WALLET" ,
                ],
                "payment_token" => $token
            ]);
            return response()->json(['msg' => $response->object()]);
        }catch(\Exception $e){
            return response()->json(['msg' => 'errrrrorrrr']);
        }
    }

    public function processed(){

    }
    public function response(){

    }
}
