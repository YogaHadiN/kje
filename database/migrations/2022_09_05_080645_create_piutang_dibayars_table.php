<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutangDibayarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutang_dibayars', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->integer('pembayaran')->nullable()->default(0);
            $table->bigInteger('pembayaran_asuransi_id')->nullable()->index('pembayaran_asuransi_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['periksa_id'], 'periksa_id_idx');
            $table->index(['periksa_id'], 'periksa_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('piutang_dibayars');
    }
}
