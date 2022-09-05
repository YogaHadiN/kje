<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_asuransis', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('asuransi_id')->nullable()->index();
            $table->date('mulai');
            $table->date('akhir');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('pembayaran')->nullable();
            $table->date('tanggal_dibayar')->nullable();
            $table->bigInteger('coa_id')->nullable()->index();
            $table->bigInteger('staf_id')->nullable()->index();
            $table->bigInteger('nota_jual_id')->nullable()->index();
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
        Schema::dropIfExists('pembayaran_asuransis');
    }
}
