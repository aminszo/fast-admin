<?php

namespace App\Http\Controllers;

use App\Models\PriceBackup;
use App\Models\PriceBackup_Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;



class testController extends Controller
{
    public function index() {

        // $url = "https://ippanel.com/services.jspd";
        // $param = array
        // (
        //     'uname'=> config('sms.username'),
        //     'pass'=> config('sms.password'),
        //     'op'=>'checkmessage',
        //     'messageid'=>'466917424'
        // );

        // $handler = curl_init($url);
        // curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        // curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        // $response2 = curl_exec($handler);
        // $response2 = json_decode($response2);

        // if(isset($response2->statusMessage)){
        //     echo $response2->statusMessage;
        //     echo '<br />';
        //     echo $response2->validMessage;
        // }else {
        //     $res_code = $response2[0];
        //     $res_data = $response2[1];
        //     echo $res_data;
        // }


//statusMessage : Finish => پایان یافته, NoContactWithTheOperator => عدم برقراری با اپراتور, Interacting =>  در حال ارتباط,
//                NoAuthentication => عدم احراز هویت, Active => فعال, NoSendSMS => عدم ارسال پیامک, Cancel => انصراف

//validMessage: approve => تایید شده, cancel => رد شده, notconfirm => منتظر تایید
    }

    public function one() {
        $url = "https://ippanel.com/services.jspd";
        $param = array
        (
            'uname'=> config('sms.username'),
            'pass'=> config('sms.password'),
            'op'=>'delivery',
            'uinqid'=>'562892393'
        );

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response2 = curl_exec($handler);
        dump($response2);

        $response2 = json_decode($response2);
        $res_code = $response2[0];
        $res_data = $response2[1];

        dump($response2);
        // dump($res_code);
        // $res = explode(",", $res_data);
        // foreach ($res as $item) {
        //     dump (explode(":" , trim($item, "[]")));
        // }
    }

    public function opo() {
        $url = "https://ippanel.com/services.jspd";
		
		$rcpt_nm = array('9121111111','9122222222');
		$param = array
					(
						'uname'=>'',
						'pass'=>'',
						'from'=>'',
						'message'=>'تست',
						'to'=>json_encode($rcpt_nm),
						'op'=>'send'
					);
					
		$handler = curl_init($url);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response2 = curl_exec($handler);
		
		$response2 = json_decode($response2);
		$res_code = $response2[0];
		$res_data = $response2[1];
		
		
		echo $res_data;
    }

    public function two() {

        $id = 2189;
        $op = [
            'regular_price' => 150000,
            'sale_price' => 100000,
        ];
        $op2 = [
            'regular_price' => 150000,
            'discount_percent' => 10,
        ];
        $op3 = [
            'discount_percent' => 10,
            'stock_status' => 'instock',
        ];


//        for ($i = 0 ; $i < 500; $i++) {
//            echo update_one_product($id, $op3);
//            echo "<br/>";
//        }


        $ids = get_products_of_category(183);
        foreach ($ids as $id) {
            update_one_product($id, $op3);
        }

        echo "done";
    }


    public function three() {
        echo now();
        $a = PriceBackup::all();
        dump($a);
        $new1 = PriceBackup_Meta::create([
            "description" => "جشنواdsfsdfsdf داوودی",
            "date" => now(),
        ]);

//        $nn = PriceBackup::create([
//            "product_id" => 120,
//            "regular_price" => "140500",
//            "sale_price" => "121000",
//            "discount_percent" => 15,
//            "sale_festival_id" => 1,
//        ]);

        dump($new1);


    }

    public function four(Request $request) {
        dump($request);
    }
}
