<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followup_transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('staf_id');
            $table->integer('rekening_id');
            $table->string('email');
            $table->date('tanggal');
            $table->bigInteger('tenant_id')->index();
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
        Schema::dropIfExists('followup_transaksis');
    }
}
