<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_asets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('harta_id')->nullable()->index('harta_id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->integer('harga_jual');
            $table->integer('harga_beli');
            $table->integer('penyusutan');
            $table->string('faktur_image');
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
        Schema::dropIfExists('penjualan_asets');
    }
}
