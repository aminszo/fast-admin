<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class bulkUpdate extends Controller
{
    public function show () {
        $categories = get_sub_categories(145);
        $categories = array_merge($categories, get_sub_categories(10723));
        $data = [
            "categories" => $categories,
        ];
        return view("admin.bulkedit", $data);
    }

    public function update(Request $request) {


        $rules = [
            'category' => [
                'required',
            ],
            'stock_status' => [
                'required',
                Rule::in(['no-change','instock','outofstock'])
            ],
            'discount_percent' => [
                'nullable',
                'numeric',
                "between:0,99",
            ],
            'regular_price' => [
                'nullable',
                'numeric',
            ],
            'sale_price' => [
                'nullable',
                'numeric',
            ],
        ];

        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return view('admin.bulkUpdate', ['errors' => $validator->errors()]);
        }

        $stock_status = $input['stock_status'];
        $regular_price = $input['regular_price'];
        $sale_price = $input['sale_price'];
        $discount_percent = $input['discount_percent'];


        if ($stock_status=="no-change" && !$regular_price
            && !$sale_price && !$discount_percent) {
            return view('admin.bulkUpdate', ['messages' => [__('no change is made')] , 'status' => 'fail']);
        }

        if ($discount_percent && $sale_price) {
            return view('admin.bulkUpdate', ['messages' => ["نمیتوانید درصد تخفیف و قیمت فروش ویژه را همزمان تعیین کنید."] , 'status' => 'fail']);
        }

        $data = [];

        if($stock_status != "no-change") {
            $data['stock_status'] = $stock_status;
        }
        if ($regular_price)
            $data['regular_price'] = $regular_price;
        if ($sale_price)
            $data['sale_price'] = $sale_price;
        if ($discount_percent)
            $data['discount_percent'] = $discount_percent;

        $all_categories = get_sub_categories(145);
        $all_categories = array_merge($all_categories, get_sub_categories(10723));

        $category_id_bag = [];
        foreach ($all_categories as $item) {
            $category_id_bag[] = $item['id'];
        }

        foreach ($input['category'] as $item) {
            if (!in_array($item, $category_id_bag)) {
                return view('admin.bulkUpdate', ['messages' => ["آیدی دسته بندی انتخاب شده نامعتبر است"] , 'status' => 'fail']);

            }
        }

        $changed = [];
        foreach ($input['category'] as $category_id) {
            $ids = get_products_of_category($category_id);
            $changed = array_merge($changed, $ids);
            foreach ($ids as $id) {
                update_one_product($id, $data);
            }
        }

        $messages = [
            count($changed)." محصول با موفقیت بروز شدند.",
        ];
        return view("admin.bulkUpdate", ['changed_ids' => $changed ,'messages' => $messages, 'status' => "success" , "cache" => true]);
    }

    public function delete_cache(Request $request) {
        if ($request->has("delete_all")) {
            delete_cache_api([], true);
            return view("admin.bulkUpdate", ['messages' => ["کش کل سایت با موفقیت پاک شد"], 'status' => "success"]);
        } else if ($request->has("id_bag")) {
            $id_bag = unserialize($request->input("id_bag"));
            delete_cache_api($id_bag, false);
            return view("admin.bulkUpdate", ['messages' => ["کش محصولات بروز شده با موفقیت پاک شد"], 'status' => "success"]);
        }
    }

}
