<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranBpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_bpjs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->integer('nilai');
            $table->date('mulai_tanggal');
            $table->date('akhir_tanggal');
            $table->date('tanggal_pembayaran');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

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
        Schema::dropIfExists('pembayaran_bpjs');
    }
}
