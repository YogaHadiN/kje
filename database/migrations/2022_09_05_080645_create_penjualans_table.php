<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('merek_id')->nullable()->index('merek_id');
            $table->bigInteger('nota_jual_id')->nullable()->index('nota_jual_id_2');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['merek_id'], 'merek_id_2');
            $table->index(['nota_jual_id'], 'nota_jual_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
