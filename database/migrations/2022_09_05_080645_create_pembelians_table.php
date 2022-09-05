<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->bigInteger('merek_id')->nullable()->index('merek_id');
            $table->integer('jumlah');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->date('exp_date');
            $table->bigInteger('faktur_belanja_id')->nullable()->index('faktur_belanja_id');
            $table->integer('harga_naik')->nullable()->default(0);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->integer('id', true);
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['merek_id'], 'merek_id_2');
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
        Schema::dropIfExists('pembelians');
    }
}
