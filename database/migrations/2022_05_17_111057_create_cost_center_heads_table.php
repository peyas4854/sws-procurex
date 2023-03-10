<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCenterHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_center_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cost_center_id');
            $table->unsignedBigInteger('employee_id');
            $table->integer('order')->unsigned()->default(1)->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_center_heads');
    }
}
