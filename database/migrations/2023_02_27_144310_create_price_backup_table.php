<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceBackupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vb_price_backup', function (Blueprint $table) {
            $table->id();
            $table->string("product_id");
            $table->string("regular_price");
            $table->string("sale_price");
            $table->string("discount_percent")->nullable();
            $table->bigInteger("sale_festival_id");
            $table->unique(['product_id', 'sale_festival_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vb_price_backup');
    }
}
