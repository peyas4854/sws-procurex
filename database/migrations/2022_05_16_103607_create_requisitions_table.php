<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_code', 150)->nullable();
            $table->string('item_type', 200)->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable()->index();
            $table->unsignedBigInteger('employee_id')->index();
            $table->date('application_date')->nullable();
            $table->date('required_date')->nullable();
            $table->string('procurement_type', 150)->nullable();
            $table->string('budget_info', 150)->nullable();
            $table->string('delivery_location', 250)->nullable();
            $table->double('approximate_cost', 15, 2)->nullable();
            $table->string('status', 30)->default('draft');
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
        Schema::dropIfExists('requisitions');
    }
}
