<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBayarGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bayar_gajis', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->date('mulai');
            $table->date('akhir');
            $table->integer('gaji_pokok')->nullable();
            $table->integer('bonus')->nullable();
            $table->date('tanggal_dibayar')->nullable();
            $table->integer('sumber_uang_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('hutang')->default(0);
            $table->bigInteger('petugas_id')->nullable()->index('petugas_id');
            $table->bigInteger('tenant_id')->index();

            $table->index(['staf_id'], 'staf_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bayar_gajis');
    }
}
