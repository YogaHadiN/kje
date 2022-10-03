<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStrExpiryDateAndSipExpiryDateToStafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stafs', function (Blueprint $table) {
            $table->date('sip_expiry_date')->nullable();
            $table->date('str_expiry_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stafs', function (Blueprint $table) {
            $table->dropColumn('sip_expiry_date');
            $table->dropColumn('str_expiry_date');
        });
    }
}
