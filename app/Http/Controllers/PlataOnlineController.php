<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mobilpay;

class PlataOnlineController extends Controller
{
    private $response;

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
        $response = 'raspuns';

        $this->response = $response;
        // return redirect('/return-url', compact('response'));
        // return view('testare-plata-card-2', compact('rezervari', 'telefoane_clienti_neseriosi'));
    }

    public function returnUrl(Request $request)
    {
        dd($request, $this->response);
        // print_r($request);
        // print_r($response);
        // $response = Mobilpay::response();

        $data = $this->response->getData();

        print_r($data);
        // dd($data, $response);
    }
}
