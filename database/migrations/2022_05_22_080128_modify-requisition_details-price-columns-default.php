<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRequisitionDetailsPriceColumnsDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisition_details', function (Blueprint $table) {
            DB::statement('alter table requisition_details modify unit_price DOUBLE(15,2) DEFAULT 0');
            DB::statement('alter table requisition_details modify price DOUBLE(15,2) DEFAULT 0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisition_details', function (Blueprint $table) {
            DB::statement('alter table requisition_details modify unit_price DOUBLE(11,2) NOT NULL');
            DB::statement('alter table requisition_details modify price DOUBLE(11,2) NOT NULL');
        });
    }
}
