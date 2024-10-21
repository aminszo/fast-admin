<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class productUpdate extends Controller
{
    public function update(Request $request) {

        // input validation rules
        $rules = [
            'id' => 'required | numeric',
            'stock_status' => [
                'required',
                Rule::in(['instock','outofstock'])
            ],
            'regular_price' => [
            'required',
            'regex:/^[0-9]+$|^\d{1,2}%$/'   // regex : only numeric value or a percentage like 25% is acceptable.
            ],
            'sale_price' => [
                'required',
                'regex:/^[0-9]+$|^\d{1,2}%$/'
            ],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            //return view('admin.productUpdate', ['errors' => $validator->errors()]);
            return view('admin.productUpdate', ['messages' => [__('Inputs are not given')] , 'status' => 'fail']);
        }
        // if inputs are valid, get inputs.
        $input = $request->all();

        // additional validation
        //  check that is there a product with this id.
        $product = DB::select("SELECT * FROM `wp_posts` WHERE `ID` = ? AND `post_type` = 'product' and `post_status` = 'publish'", [$input['id']]);

        // if product id is not valid display an error message.
        if(empty($product)){
            return view('admin.productUpdate', ['messages' => [__('product id is invalid')] , 'status' => 'fail']);
        }

        // get current product properties to compare with new input.
        $current_product =  get_current_product($input['id']);

        if (preg_match("/^\d{1,2}%$/", $input['regular_price'])) {
            $input['regular_price'] = (int)trim($input['regular_price'], '%');
            if ($input['regular_price'] > 99 || $input['regular_price'] < 0) {
                return view('admin.productUpdate', ['messages' => [__('regular price is invalid')] , 'status' => 'fail']);
            }
            $input['regular_price'] = (int) ((int)$current_product['regular_price'] * ((100 - $input['regular_price']) / 100));
            $input['regular_price'] = (string) $input['regular_price'];
        }

        if (preg_match("/^\d{1,2}%$/", $input['sale_price'])) {
            $input['sale_price'] = (int)trim($input['sale_price'], '%');
            if ($input['sale_price'] > 99 || $input['sale_price'] < 0) {
                return view('admin.productUpdate', ['messages' => [__('sale price is invalid')] , 'status' => 'fail']);
            }
            $input['sale_price'] = (int) ((int)$input['regular_price'] * ((100 - $input['sale_price']) / 100));
            $input['sale_price'] = (string) $input['sale_price'];
        } else {
            if ( (int)$input['sale_price'] > (int)$input['regular_price'] ) {
                return view('admin.productUpdate', ['messages' => [__('sale price should be smaller than regular price')],  'status' => 'fail' ]);
            }
        }


        // a variable to check if any change is made to database or not.
        $is_updated = false;
        $messages = [];
        $status = "success";

        // updating stock_status
        if($current_product['stock_status'] != $input['stock_status']) {
            $update_query0 = "UPDATE `wp_wc_product_meta_lookup` SET `stock_status` = ? WHERE `product_id` = ?";
            $update_query1 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_stock_status' ";

            $update_result[0] = DB::update($update_query0 , [$input['stock_status'] , $input['id']]);
            $update_result[1] = DB::update($update_query1 , [$input['stock_status'] , $input['id']]);

            if ($update_result[0] && $update_result[1])
                $messages[] = __("stock status updated");
            else {
                $messages[] = __("stock status update failed");
                $status = "fail";
            }
            $is_updated = true;
        }

        // updating regular price
        if ($current_product['regular_price'] != $input['regular_price']) {

            $update_query2 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_regular_price'";
            $update_result[2] = DB::update($update_query2 , [$input['regular_price'] , $input['id']]);

            if ($update_result[2])
                $messages[] = __("regular price updated");
            else {
                $messages[] = __("regular price update failed");
                $status = "fail";
            }
            $is_updated = true;
        }

        // updating sale price
        if ($current_product['sale_price'] != $input['sale_price']) {

            $update_query3 = "UPDATE `wp_wc_product_meta_lookup` SET `min_price` = ? , `max_price` = ? WHERE `product_id` = ?";
            $update_query4 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_price' ";
            $update_query5 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_sale_price' ";

            $update_result[3] = DB::update($update_query3 , [$input['sale_price'], $input['sale_price'], $input['id']]);
            $update_result[4] = DB::update($update_query4 , [$input['sale_price'], $input['id']]);
            $update_result[5] = DB::update($update_query5 , [$input['sale_price'], $input['id']]);

            if ($update_result[5] == 0) {
                $sale_price_exists =  DB::select("SELECT `meta_value` FROM `wp_postmeta` WHERE `post_id` = ? AND `meta_key` = '_sale_price'" , [$input['id']]);
                if (empty($sale_price_exists)) {
                    $update_result[5] = DB::update("INSERT INTO `wp_postmeta` (post_id , meta_key , meta_value) VALUES (?, '_sale_price' , ?)", [$input['id'], $input['sale_price']] );
                }
            }

            if ($update_result[3] && $update_result[4] && $update_result[5])
                $messages[] = __("sale price updated");
            else {
                $messages[] = __("sale price update failed");
                $status = "fail";
            }

            $is_updated = true;
        }

        // if product is updated, we delete cache of that product (if available)
        if ($is_updated) {
            delete_cache_api($input['id'], false);
            $messages[] = __("product cache deleted");

        } else // if product is not updated. show a message.
            $status = "nochange";

        switch ($status) {
//            case "success" :
//                $messages[] = __("update_success_alert");
//                break;
            case "fail" :
                $messages[] = __("update_fail_alert");
                break;
            case "nochange" :
                $messages[] = __("update_nochange_alert");
                break;
        }

        return view("admin.productUpdate", ['messages' => $messages, 'status' => $status]);
    }
}
