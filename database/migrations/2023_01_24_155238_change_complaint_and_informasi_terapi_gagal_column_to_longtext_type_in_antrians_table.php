<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeComplaintAndInformasiTerapiGagalColumnToLongtextTypeInAntriansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->longText('complaint')->change();
            $table->longText('informasi_terapi_gagal')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->string('complaint')->change();
            $table->string('informasi_terapi_gagal')->change();
        });
    }
}
