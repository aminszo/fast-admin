<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceBackup extends Model
{
    use HasFactory;

    protected $table = 'vb_price_backup';
    public $timestamps = false;
    protected $fillable = ["product_id", "regular_price", "sale_price", "discount_percent", "sale_festival_id"];

}
