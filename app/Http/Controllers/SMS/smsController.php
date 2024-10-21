<?php

namespace App\Http\Controllers\SMS;

use App\Helpers\smsHelper as SMS;
use App\Http\Controllers\Controller;
use App\Models\SmsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class smsController extends Controller
{

    /* Display the main send sms page view */
    public function show_sms_page()
    {
        
        return view('sms.send-sms');
    }

    /* Display the pattern send sms page view */
    public function show_pattern_sms_page()
    {
        return view('sms.send-pattern-sms');
    }

    /* Display the send sms page view for books buying */
    public function show_sms_book()
    {
        return view('sms.send-sms-book');
    }


    /**
     * Send an sms to a single phone number or a list of phone numbers with variable text
     */
    public function send_sms(Request $request)
    {

        $rules = [
            'phone-numbers' => [
                "required",
            ],
            'sms-text' => [
                "required",
                "string",
                "min:10",
                "max:190",
            ],
            "sms-type" => [
                "required",
                Rule::in(['advertise', 'service']),
            ]
        ];

        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return view('sms.sms-result', ['status' => "fail", 'messages' => ["خطا در ورودی ها"], 'errors' => $validator->errors()]);
        }

        $phone_numbers = $input['phone-numbers'];

       

        $result = SMS::validate_phone_numbers($phone_numbers);

        // dump("hi");
        // dd($result["phone_list"]);

        if ($result['is_failed']) {
            $data = [
                "status" => "fail",

                "messages" => $result['messages']
            ];
            return view('sms.sms-result', $data);
        }

        if ($input['sms-type'] == "advertise") {
            $sender_number = '+9810004223';
        } elseif ($input['sms-type'] == "service") {
            $sender_number = '+983000505';
        }
        $parameters = array(
            'sms-text' => $input['sms-text'],
            "sender_number" => $sender_number,
            'phone-number' => $result['phone_list'],
        );

        $response = SMS::send_sms_with_text($parameters);

        $response_code = $response[0];
        $response_data = $response[1];

        if ($response_code == 0) {
            $data = [
                "status" => "success",
                "messages" => [
                    "با موفقیت ارسال شد",
                    "کد پیگیری پیام : $response_data"
                ],
            ];
            SmsReport::create(["bulk_id" => $response_data]);
        } else {
            $data = [
                "status" => "fail",
                "messages" => [
                    "ارسال پیام با خطا مواجه شد.",
                    $response_data,
                ],
            ];
        }

        return view('sms.sms-result', $data);
    }


    /**
     * send a single sms with an specific pattern (constant text)
     */
    public function send_pattern_sms(Request $request)
    {
        $rules = [
            'phone-numbers' => [
                "required",
            ],
            'rahgiri_code' => [
                "required",
                "string",
                "min:6",
                "max:30",
            ],
        ];

        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return view('sms.sms-result', ['status' => "fail", 'messages' => ["خطا در ورودی ها"], 'errors' => $validator->errors()]);
        }


        $phone_number = $input['phone-numbers'];
        $result = SMS::validate_phone_numbers($phone_number);

        if ($result['is_failed']) {
            $data = [
                "status" => "fail",
                "messages" => $result['messages']
            ];
            return view('sms.sms-result', $data);
        }

        $parameters = array(
            "pattern_code" => "44s0jv6nacqgsx8",
            "phone_number" => $result['phone_list'],
            "variable_values" => array(
                "tracking_code" => $input['rahgiri_code'],
            ),
        );

        $response = SMS::send_sms_by_pattern($parameters);

        if (is_numeric($response)) {
            $data = [
                "status" => "success",
                "messages" => [
                    "با موفقیت ارسال شد",
                    "کد پیگیری پیام : $response"
                ],
            ];
            SmsReport::create(["bulk_id" => $response]);
        } else {
            $data = [
                "status" => "fail",
                "messages" => [
                    "ارسال پیام با خطا مواجه شد.",
                    $response,
                ],
            ];
        }

        return view('sms.sms-result', $data);
    }

    public function show_deliver_status(Request $request) {
        $input = $request->all();
        SMS::get_deliver_status($input["uid"]);
    }
}
