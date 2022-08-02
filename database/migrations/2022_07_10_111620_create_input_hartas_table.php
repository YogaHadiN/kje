<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputHartasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('input_hartas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('harta');
            $table->string('coa_id');
            $table->date('tanggal_beli');
            $table->date('tanggal_dijual')->nullable();
            $table->string('coa_penyusutan_id');
            $table->integer('hutang_terbayar');
            $table->string('coa_hutang_id');
            $table->string('harga');
            $table->integer('metode_bayar_id');
            $table->integer('uang_muka');
            $table->integer('harga_jual');
            $table->integer('status_harta_id');
            $table->integer('lama_cicilan');
            $table->integer('masa_pakai');
            $table->string('staf_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('tax_amnesty')->default(0);
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
        Schema::dropIfExists('input_hartas');
    }
}
