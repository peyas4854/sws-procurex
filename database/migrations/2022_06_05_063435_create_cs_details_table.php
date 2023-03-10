<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_details', function (Blueprint $table) {
            $table->id();
            $table->string('cs_number', 250);
            $table->unsignedBigInteger('requester_employee_id')->nullable();
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->longText('justification_for_procurement')->nullable();
            $table->text('justification_for_vendor_selection')->nullable();
            $table->unsignedBigInteger('cost_center_id')->nullable()->index();
            $table->string('budget_info', 150)->nullable()->default('budgeted');
            $table->string('status', 30)->default('pending');
            $table->dateTime('status_date')->nullable();
            $table->string('delivery_location', 250)->nullable();
            $table->unsignedBigInteger('approval_team_id')->nullable();
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
        Schema::dropIfExists('cs_details');
    }
}
