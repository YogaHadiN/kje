<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappCekListHariansTable extends Migration
{
    public function up(){
        Schema::create('whatsapp_cek_list_harians', function (Blueprint $table) {
            $table->id();
            $table->string('no_telp');
            $table->integer('staf_id');
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
        Schema::dropIfExists('whatsapp_cek_list_harians');
    }
}
