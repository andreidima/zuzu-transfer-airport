<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mobilpay;

class PlataOnlineController extends Controller
{

    public function testarePlataCard(Request $request)
    {
        return view('testare-plata-card');
    }

    public function trimitereCatrePlata(Request $request)
    {
        $comanda = Mobilpay::setOrderId(md5(uniqid(rand())))
        ->setAmount('10.00')
        ->setDetails('Some details')
        // ->setReturnUrl('https://www.youtube.com');
        ->purchase();
        // dd($comanda);
    }

    public function confirmarePlata(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData(); //array

        // $request = (string) $data->orderId;

        $data_string = $response->toJson();

        // dd($response, $data);
        // $mobilpay = Mobilpay::response();
        // $mobilpay = (string) $mobilpay;

        // $data = implode(', ', $data);

        // $array = $response->toArray();
        // echo implode(', ', $array);

        DB::table('teste')->insert(
            ['text' => $request, 'text3' => $data_string ]
        );

        switch ($response->getMessage()) {
            case 'confirmed_pending': // transaction is pending review. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "pending"

                break;
            case 'paid_pending': // transaction is pending review. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "pending"

                break;
            case 'paid': // transaction is pending authorization. After this is done, a new IPN request will be sent with either confirmation or cancellation

                //update DB, SET status = "open/preauthorized"

                break;
            case 'confirmed': // transaction is finalized, the money have been captured from the customer's account

                //update DB, SET status = "confirmed/captured"

                break;
            case 'canceled': // transaction is canceled

                //update DB, SET status = "canceled"

                break;
            case 'credit': // transaction has been refunded

                //update DB, SET status = "refunded"

                break;
        }	
    }

    public function returnUrl(Request $request)
    {

        // $response = Mobilpay::response();

        // $data = $response->getData(); //array

        // print_r($request);
        // print_r($response);
        // $response = Mobilpay::response();

        // $data = $this->response->getData();

        // print_r($data);
        // dd($request->implode('-'));
        // dd($request->toArray()->implode('-'));
        
        $array = $request->toArray();
        echo implode(', ', $array);

    }
}
