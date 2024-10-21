<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceBackup_Meta extends Model
{
    use HasFactory;

    protected $table = 'vb_price_backup_meta';
    public $timestamps = false;
    protected $fillable = ["description", "date", "product_count"];
}
