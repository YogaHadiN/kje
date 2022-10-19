<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeJenisTarifIdToJenisTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_tarifs', function (Blueprint $table) {
            $table->integer('tipe_jenis_tarif_id')->default(8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_tarifs', function (Blueprint $table) {
            $table->dropColumn('tipe_jenis_tarif_id');
        });
    }
}
