<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->unsignedBigInteger('designation_id')->nullable()->index();
            $table->unsignedBigInteger('cost_center_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('code', 100);
            $table->string('first_name', 250);
            $table->string('middle_name', 250)->nullable();
            $table->string('last_name', 250)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('profile_photo', 100)->nullable();
            $table->unsignedBigInteger('remote_employee_id')->nullable()->index();
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
        Schema::dropIfExists('employees');
    }
}
