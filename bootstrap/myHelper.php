<?php

use App\Http\Controllers\Assist;
use Illuminate\Support\Facades\DB;

/**
 * [amin] this is a custom helper file and includes all helper functions I need.
 */

function toArray($queryResult): array
{
    /* get a sql query result which is of stdClass type and converts it to array. */
    $arr = array_map(function ($value) {
        return (array)$value;
    }, $queryResult);
    return $arr;
}

function get_current_product ($product_id) : array
{
    // get woocommerce product properties with product id.
    $get_current_product_sql = "SELECT
            CASE WHEN `meta_key` = '_sale_price' THEN `meta_value` END AS `sale_price`,
            CASE WHEN `meta_key` = '_regular_price' THEN `meta_value` END AS `regular_price`,
            CASE WHEN `meta_key` = '_stock_status' THEN `meta_value` END AS `stock_status`
            FROM `wp_postmeta` WHERE `post_id` = ?
            AND `meta_key` IN ('_sale_price', '_regular_price', '_stock_status')";
    $temp_result = DB::select($get_current_product_sql, [$product_id]);
    // with above sql query, we get a result with some null values, with this loop we can pick only values that we need.
    $current_product = [
        'stock_status' => '',
        'regular_price' => '',
        'sale_price' => '',
    ];
    foreach (toArray($temp_result) as $result)
        foreach ($result as $key => $value)
            if (!is_null($value))
                $current_product[$key] = $value;

    return $current_product;
}

function get_sub_categories($id=0): array
{
    /*
     * retrieve sub categories of a 'product category id' from wordPress database. and calculate products count of each category
     * default category id is 0 which make it to get all product categories.
     */
    $sql = "SELECT `wp_term_taxonomy`.`term_id` as id , `name` , `count` FROM `wp_term_taxonomy` INNER JOIN `wp_terms` ON
                `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` WHERE `wp_term_taxonomy`.`taxonomy` = 'product_cat' AND `parent` = ?";

    $children = toArray( DB::select($sql, [$id]) );

    if (count($children) != 0 ) {
        foreach ($children as $key => $child) {
            $sub = get_sub_categories($child['id']);
            $children[$key]['sub'] = $sub;

            foreach ($sub as $item) {
                $children[$key]['count'] += $item['count'];
            }
        }
    } else {
        return $children;
    }

    return $children;
}

function update_one_product($product_id, $args ) {

    $current_product = get_current_product($product_id);

    $stock_status = $args['stock_status'] ?? null;
    if ($stock_status && $stock_status != $current_product['stock_status'] ) {
        $update_query0 = "UPDATE `wp_wc_product_meta_lookup` SET `stock_status` = ? WHERE `product_id` = ?";
        $update_query1 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_stock_status' ";
        $update_result[0] = DB::update($update_query0 , [$stock_status , $product_id]);
        $update_result[1] = DB::update($update_query1 , [$stock_status , $product_id]);
    }

    if (isset($args['regular_price'])) {
        $regular_price = $args['regular_price'];
        if(isset($args['sale_price'])) {
            $sale_price = $args['sale_price'];
        } elseif (isset($args['discount_percent'])) {
            $sale_price = $regular_price * ((100 - $args['discount_percent']) / 100 );
        }
    } elseif (!isset($args['discount_percent'])) {
        return "error";
    } else { // if regular price is not set and discount_percent is set:
        $regular_price = $current_product['regular_price'];

        if (!is_numeric($regular_price)) {
            return "error";
        }
        $sale_price = $regular_price * ((100 - $args['discount_percent']) / 100 );
    }

    $update_query2 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_regular_price'";
    $update_result[2] = DB::update($update_query2 , [$regular_price , $product_id]);

    $update_query3 = "UPDATE `wp_wc_product_meta_lookup` SET `min_price` = ? , `max_price` = ? WHERE `product_id` = ?";
    $update_query4 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_price' ";
    $update_query5 = "UPDATE `wp_postmeta` SET `meta_value` = ? WHERE `post_id` = ? AND `meta_key` = '_sale_price' ";

    $update_result[3] = DB::update($update_query3 , [$sale_price, $sale_price, $product_id]);
    $update_result[4] = DB::update($update_query4 , [$sale_price, $product_id]);
    $update_result[5] = DB::update($update_query5 , [$sale_price, $product_id]);

    if ($update_result[5] == 0) {
        $sale_price_exists =  DB::select("SELECT `meta_value` FROM `wp_postmeta` WHERE `post_id` = ? AND `meta_key` = '_sale_price'" , [$product_id]);
        if (empty($sale_price_exists)) {
            $update_result[5] = DB::update("INSERT INTO `wp_postmeta` (post_id , meta_key , meta_value) VALUES (?, '_sale_price' , ?)", [$product_id, $sale_price] );
        }
    }

    foreach ($update_result as $result) {
        if (!$result) {
            return "error";
        }
    }

    return "ok";

}

function get_products_of_category ($category_id) {
    $sql = "SELECT `object_id` AS id from `wp_term_relationships` where term_taxonomy_id= ? and object_id in (select ID from `wp_posts` where `post_type`='product' and post_status='publish')";
    $result = DB::select($sql, [$category_id]);
    $id_bag = [];
    foreach ($result as $item) {
        $id_bag[] = $item->id;
    }
    return $id_bag;

}

function delete_cache_api ($id_bag, $all=false) {

    if ($all == true) {
        $params = array
        (
            'secret' => "magic_4509@698",
            'clear_all' => "true"
        );
    } elseif (!is_array($id_bag)) {
        $params = array
        (
            'secret' => "magic_4509@698",
            'single_id' => $id_bag,
        );
    } else {
        $params = array
        (
            'secret' => "magic_4509@698",
            'id_bag' => serialize($id_bag),
        );
    }

    $handler = curl_init();
    $curl_options = array(
        CURLOPT_URL => "https://vitaminbook.ir/cache_api.php",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($handler, $curl_options);
    $response = curl_exec($handler);
    curl_close($handler);

    return true;
}


