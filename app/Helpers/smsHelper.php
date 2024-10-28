<?php

namespace App\Helpers;

/**
 * [amin] this file include all functions for sms features.
 */

class smsHelper
{

    public static $username = "";
    public static $password = "";

    public static function send_sms_with_text($data)
    {
        $params = array(
            'uname' => self::$username,
            'pass' => self::$password,
            'from' => $data['sender_number'],
            'message' => $data['sms-text'],
            'to' => json_encode($data['phone-number']),
            'op' => 'send'
        );

        $handler = curl_init();
        $curl_options = array(
            CURLOPT_URL => "https://ippanel.com/services.jspd",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($handler, $curl_options);

        // dump($data['phone-number']);
        // dd($params['to']);
        // die("temporary disabled");
        $response = curl_exec($handler);
        curl_close($handler);

        $response = json_decode($response);

        return $response;
    }

    public static function send_sms_by_pattern($params)
    {

        // these values are constant
        $from = "+983000505";

        // these values are passed to the function in $params 
        $pattern_code = $params['pattern_code'];
        $to = array($params['phone_number'][0]);
        $input_data = $params['variable_values'];

        $url = "https://ippanel.com/patterns/pattern?username=" . self::$username . "&password=" . urlencode(self::$password,) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";
        $handler = curl_init();
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $input_data,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($handler, $curl_options);
        $response = curl_exec($handler);
        curl_close($handler);

        return $response;
    }

    public static function validate_phone_numbers($phone_numbers)
    {
        $mobile_number_regex = "/^9[01239]{1}[0-9]{8}$/";
        $fail = 0;
        $messages = [];

        $phone_list = preg_split('/\r\n|[\r\n]/', $phone_numbers);

        foreach ($phone_list as $key => $number) {
            $p = strtr($phone_list[$key], array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));

            $phone_list[$key] =  ltrim($p, '0');

            if (!preg_match($mobile_number_regex, $phone_list[$key])) {
                $messages[] = "شماره موبایل " . "0" . $phone_list[$key] . " نادرست است.";
                $fail = 1;
            }
        }

        return array(
            "phone_list" => $phone_list,
            "messages" => $messages,
            "is_failed" => $fail,
        );
    }

    public static function get_deliver_status($uid)
    {
        $url = "https://ippanel.com/services.jspd";
        $param = array(
            'uname' => self::$username,
            'pass' => self::$password,
            'op' => 'delivery',
            'uinqid' => $uid,
        );

        $handler = curl_init($url);

        $curl_options = array(
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($handler, $curl_options);

        $response = curl_exec($handler);
        curl_close($handler);

        $response = json_decode($response);
        $res_code = $response[0];
        $res_data = json_decode($response[1]);

        foreach ($res_data as $item) {
            dump (explode(":" , trim($item, "[]")));
            // dump($item);
        }
        // echo $res_data;
    }
}
