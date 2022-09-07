<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanBangunansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_bangunans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_renovasi_selesai')->nullable();
            $table->date('tanggal_terakhir_dikonfirmasi')->nullable();
            $table->integer('bangunan_permanen');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('faktur_belanja_id')->nullable()->index();
            $table->string('keterangan')->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->integer('jumlah')->nullable();
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
        Schema::dropIfExists('bahan_bangunans');
    }
}
