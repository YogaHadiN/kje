<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBagiGigisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bagi_gigis', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('petugas_id')->nullable()->index('petugas_id');
            $table->integer('nilai');
            $table->date('tanggal_dibayar');
            $table->date('mulai');
            $table->date('akhir');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bagi_gigis');
    }
}
