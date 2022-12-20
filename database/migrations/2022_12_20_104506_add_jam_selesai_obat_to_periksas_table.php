<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJamSelesaiObatToPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periksas', function (Blueprint $table) {
            $table->time('jam_selesai_obat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periksas', function (Blueprint $table) {
            $table->dropColumn('jam_selesai_obat');
        });
    }
}
