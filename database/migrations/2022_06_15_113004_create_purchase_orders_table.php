<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_code', 150)->nullable();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->dateTime('application_date')->nullable();
            $table->text('delivery_location')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable()->index();
            $table->string('procurement_type', 150)->nullable();
            $table->string('budget_info', 150)->nullable();
            $table->string('status', 30)->default('pending');
            $table->dateTime('status_date')->nullable();
            $table->longText('terms_and_condition')->nullable();
            $table->double('total_price_without_vat',20,2);
            $table->double('total_price_with_vat',20,2);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
