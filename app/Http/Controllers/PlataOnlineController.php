<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mobilpay;
use Storage;

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
        ->setAdditionalParams([
            // 'email' => $request->email
            'email' => 'andrei.dima@usm.ro',
            'firstName' => 'Andrei Dima'
        ])
        ->purchase();
        // dd($comanda);
    }

    public function confirmarePlata(Request $request)
    {
        $response = Mobilpay::response();

        $data = $response->getData(); //array

        // $request = (string) $data->orderId;

        // $data_string = $response->toJson();

        // dd($response, $data);

        $string = '';



        function recursiva($array, $level = 1, $string1 = '')
        {
            foreach ($array as $key => $value) {
                //If $value is an array.
                if (is_array($value)) {
                    //We need to loop through it.
                    recursiva($value, $level + 1);
                } else {
                    //It is not an array, so print it out.
                    // echo $key . ": " . $value, '<br>';
                    $string1 = $string1 . $key . ": " . $value . "\n";
                }
            }
            return $string1;
        }

        // $string = reset($data) . "\n";
        $string = $string . recursiva($data);



        function array_values_recursiva($array, $level = 1)
        {
            $flat = array();

            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $flat[] = "\n\n";
                    $flat[] = "Level: " . $level . " key: " . $key . "\n";
                    $flat = array_merge($flat, array_values_recursiva($value, $level + 1));
                } else {
                    $flat[] = $key;
                    $flat[] = $value;
                    $flat[] = "\n";
                }
            }
            return $flat;
        }

        $string2 = '';
        $string2 = array_values_recursiva($data);

        $string3 = implode(" ", $string2);



        // Storage::put('file.txt', $response);
        Storage::put('file2.txt', reset($data));
        Storage::put('file3.txt', $string3);
        Storage::put('file.txt', $data['orderId']);

        // $mobilpay = Mobilpay::response();
        // $mobilpay = (string) $mobilpay;

        // $data = implode(', ', $data);

        // $array = $response->toArray();
        // echo implode(', ', $array);

        DB::table('payment_notifications')->insert([
            'order_id' => 'orderId',
            'purchase_id' => 'a',
            'action' => 'action',
            'error_code' => 'errorCode',
            'error_message' => 'errorMessage',
            'notify_date' => 'a',
            'original_amount' => 'a',
            'processed_amount' => 'a',
            'pan_masked' => 'a',
            'customer_id' => 'a',
            'payment_instrument_id' => 'a',
        ]);

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

        $matrice = array(
            'fruct' => 'cireasa',
            'pret' => '3'
        );

        $string = '';

        foreach ($matrice as $x => $x_value) {
            $string =  $string . "Key=" .  $x . ", Value=" . $x_value;
        }
        
        echo gettype ($string);
        echo ($string);

        // dd($matrice);

        // $array = $request->toArray();
        // echo implode(', ', $array);

        $arr = [
            "_token" => "aHgDik0zuDxxBqYgbi0ZTkaPyG3CVwk5WO7LtU6u",
            "contractor_invoice_no" => "",
            "date" => "26-11-2015",
            "contractor_reference" => "sdfsdf",
            "workorder_reference" => "151 alandale",
            "square_installed" => "455",
            "square_invoice" => "677",
            "other_work_" => array(1, array('a', 'b', array('one' => 'path'))),
            "other_invoice_" => array(1, 2, 3),
            "comments" => "comments"
        ];

        echo '<br>';
        echo $arr['date'];
        echo '<br><br><br>';
        echo $arr['other_work_'][1][2]['one'];
        echo '<br><br><br>';

        $myArray = array(
            'example',
            'example two',
            array(
                'another level',
                array(
                    'level three'
                )
            )
        );

        $string = '';

        function recursive($array, $level = 1)
        {
            $string1 = '';
            foreach ($array as $key => $value) {
                //If $value is an array.
                if (is_array($value)) {
                    //We need to loop through it.
                    recursive($value, $level + 1, $string1);
                } else {
                    //It is not an array, so print it out.
                    echo $key . ": " . $value, '<br>';
                    $string1 = $string1 . $key . ": " . $value . "\n";
                }
            }
            return $string1;
        }

        $string = reset($arr) . "\n";
        $string = $string . recursive($arr);

        // recursive($arr);

        echo $string;



        function array_values_recursive($array, $level = 1)
        {
            $flat = array();

            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $flat[] = "<br><br>";
                    $flat[] = "Level: " . $level . " key: " . $key . "<br>";
                    $flat = array_merge($flat, array_values_recursive($value, $level + 1));
                } else {
                    $flat[] = $key;
                    $flat[] = $value;
                    $flat[] = "<br>";
                }
            }
            return $flat;
        }

        $string2 = '';
        $string2 = array_values_recursive($arr);

        $string3 = implode(" ", $string2);
        // foreach (array_values_recursive($arr) as $value){
        //     $string2 = $string2 . $value;
        // }
        echo '<br><br><br><br>';
        echo $string3;

    }
}
