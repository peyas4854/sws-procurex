<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_code', 100)->nullable();
            $table->string('name', 200);
            $table->string('address', 250)->nullable();
            $table->string('office_phone', 30)->nullable();
            $table->string('office_email', 100)->nullable();
            $table->text('bin', 100)->nullable();
            $table->text('tin', 100)->nullable();
            $table->text('trade_license', 100)->nullable();
            $table->string('bank_account_name', 100)->nullable();
            $table->text('bank_account_number', 100)->nullable();
            $table->text('bank_routing_number', 100)->nullable();
            $table->text('bank_name', 100)->nullable();
            $table->text('bank_branch', 100)->nullable();
            $table->boolean('status')->default('1');
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
        Schema::dropIfExists('vendors');
    }
}
