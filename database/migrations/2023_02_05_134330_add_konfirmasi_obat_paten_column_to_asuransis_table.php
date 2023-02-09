<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKonfirmasiObatPatenColumnToAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asuransis', function (Blueprint $table) {
            $table->tinyInteger('konfirmasi_obat_paten')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asuransis', function (Blueprint $table) {
            $table->dropColumn('konfirmasi_obat_paten');
        });
    }
}
