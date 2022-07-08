<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBayarBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bayar_bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('staf_id');
            $table->date('mulai');
            $table->date('akhir');
            $table->integer('pembayaran')->nullable();
            $table->date('tanggal_dibayar')->nullable();
            $table->string('kas_coa_id')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bayar_bonus');
    }
}
