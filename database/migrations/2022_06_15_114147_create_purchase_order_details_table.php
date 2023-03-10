<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('uom_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->integer('quantity');
            $table->double('unit_price',11,2);
            $table->double('total_price_without_vat',20,2);
            $table->double('vat',11,2);
            $table->double('vat_amount',11,2);
            $table->double('total_price_with_vat',20,2);
            $table->longtext('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
