<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class adminController extends Controller
{
    public function showDashboard(Request $request) {
        $total = DB::select("SELECT COUNT(`ID`) AS count FROM `wp_posts` WHERE `post_type` = 'product'");
        $in_stock = DB::select("SELECT COUNT(post_id) as count FROM `wp_postmeta` WHERE `meta_key` = '_stock_status' AND `meta_value` = 'instock' ");
        $out_of_stock = DB::select("SELECT COUNT(post_id) as count FROM `wp_postmeta` WHERE `meta_key` = '_stock_status' AND `meta_value` = 'outofstock' ");

        $publishers_parent_category_id = 145;
        $sql = "SELECT `wp_terms`.`term_id` AS id , `name` , `count` FROM `wp_terms`
                INNER JOIN `wp_term_taxonomy` ON `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id`
                WHERE `taxonomy` = 'product_cat' AND `parent` = ? ORDER BY `count` DESC ";

        $publishers = DB::select($sql, [$publishers_parent_category_id]);

        $best_sellers_sql = "SELECT `product_id` AS id, `post_title` as title, `total_sales` AS sales
            FROM `wp_wc_product_meta_lookup` INNER JOIN `wp_posts`
            ON wp_wc_product_meta_lookup.product_id = wp_posts.ID
            WHERE `total_sales` > 0 ORDER BY `wp_wc_product_meta_lookup`.`total_sales` DESC LIMIT 10 ";

        $best_sellers = DB::select($best_sellers_sql);

        $categories = get_sub_categories();

        $data = [
            'total_count' => $total[0]->count,
            'instock_count' => $in_stock[0]->count,
            'outofstock_count' => $out_of_stock[0]->count,
            'publishers' => $publishers,
            'categories' => $categories,
            'best_sellers' => $best_sellers,
        ];
        return view("admin.dashboard", $data);
    }
    public function showProducts(Request $request) {

        if ($request->has('search')) {
            $search_words =  explode(" ", $request->get('search'));
            $query = "SELECT `ID`,`post_title` FROM `wp_posts` WHERE `post_type` = 'product' and `post_status` = 'publish'";
            for ($i = 0 ; $i < count($search_words) ; $i++) {
                $search_words[$i] = "%".$search_words[$i]."%";
                $query .= " AND `post_title` LIKE ?";
            }
            $products = DB::select($query, $search_words);
        }
        else {
            $products = DB::select("SELECT `ID`,`post_title` FROM `wp_posts` WHERE `post_type` = 'product' and `post_status` = 'publish'");
        }

        foreach ($products as $product) {
            $properties = get_current_product($product->ID);
            $product->stock_status = $properties['stock_status'] ?? '';
            $product->regular_price = $properties['regular_price'] ?? '';
            $product->sale_price = $properties['sale_price'] ?? '';
        }

        // return view with $data
        $data = [
            'products' => $products
        ];
        return view('admin.products' , $data);
    }
}
