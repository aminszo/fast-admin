<?php

namespace App\Http\Controllers;

use App\Models\PriceBackup_Meta;
use App\Models\PriceBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class festival extends Controller
{
    public function show() {
        $all_backups = PriceBackup_Meta::all();
        return view("admin.festival", ["backups" => $all_backups]);
    }

    public function create(Request $request) {
        $rules = [
            'description' => [
                'required',
                'min:10',
                'max:150',
            ],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return view('admin.backupResult', ['errors' => $validator->errors()]);
//            return view('admin.festival', ['messages' => [__('Inputs are not given')] , 'status' => 'fail']);
        }

        $products = DB::select("SELECT `ID` FROM `wp_posts` WHERE `post_type` = 'product' and `post_status` = 'publish'");

        $new_backup = PriceBackup_Meta::create([
            "description" => $request->input("description"),
            "date" => now(),
            "product_count" => count($products),
        ]);

        $festival_id = $new_backup->id;
        foreach ($products as $product) {
            $properties = get_current_product($product->ID);
            $regular_price = $properties['regular_price'] ?? false;
            $sale_price = $properties['sale_price'] ?? false;

            if ($regular_price && $sale_price) {
                $discount_percent = (( (int)$regular_price - (int)$sale_price) / (int)$regular_price) * 100;
            } else {
                $discount_percent = null;
            }

            PriceBackup::create([
            "product_id" => $product->ID,
            "regular_price" => $regular_price,
            "sale_price" => $sale_price,
            "discount_percent" => (int)$discount_percent,
            "sale_festival_id" => $festival_id,
            ]);
        }
        return view('admin.backupResult', ['messages' => ["با موفقیت انجام شد"] , 'status' =>"success"]);

    }
    public function apply(Request $request) {

        $id = $request->input("id");

        if ($request->has("delete")) {
            PriceBackup_Meta::where("id" , $id)->delete();

            PriceBackup::where("sale_festival_id", $id)->delete();

            return redirect()->route("festival");
        }

        $all = PriceBackup::where("sale_festival_id", $id)->get();
        $i = 0;
        foreach ($all as $item) {

            if ($item->discount_percent) {
                $data = [
                    'discount_percent' => $item->discount_percent,
                ];
                update_one_product($item->product_id, $data);
                $i++;
            }

        }
        echo "<br/>".$i;
    }
}
