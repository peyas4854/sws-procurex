<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJustificationForVendorSelectionInCsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cs_details', function (Blueprint $table) {
            $table->longText('justification_for_vendor_selection')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cs_details', function (Blueprint $table) {
            $table->text('justification_for_vendor_selection')->nullable();
        });
    }
}
