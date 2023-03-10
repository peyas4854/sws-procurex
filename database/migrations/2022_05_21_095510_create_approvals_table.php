<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvalable');
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('forwarded_by_employee_id')->nullable()->index();
            $table->tinyInteger('is_forwarded')->default(0);
            $table->tinyInteger('authority_order')->default(1);
            $table->string('status')->default('pending');
            $table->dateTime('status_date')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable()->index();
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
        Schema::dropIfExists('approvals');
    }
}
