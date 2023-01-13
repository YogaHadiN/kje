<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCekListRuanganIdToCekListHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cek_list_harians', function (Blueprint $table) {
            $table->integer('cek_list_ruangan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cek_list_harians', function (Blueprint $table) {
            $table->dropColumn('cek_list_ruangan_id');
        });
    }
}
