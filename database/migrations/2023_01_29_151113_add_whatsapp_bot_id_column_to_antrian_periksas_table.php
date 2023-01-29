<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappBotIdColumnToAntrianPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('antrian_periksas', function (Blueprint $table) {
            $table->integer('whatsapp_bot_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrian_periksas', function (Blueprint $table) {
            $table->dropColumn('whatsapp_bot_id');
        });
    }
}
