<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('harga_beli')->nullable()->default(0);
            $table->integer('harga_jual')->nullable();
            $table->date('exp_date')->nullable();
            $table->integer('fornas');
            $table->integer('stok_minimal')->default(0);
            $table->integer('stok')->default(0);
            $table->bigInteger('formula_id')->nullable()->index('formula_id');
            $table->string('alternatif_fornas')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('kelas_obat_id')->nullable()->default(2);
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('kode_rak')->index('kode_rak');

            $table->index(['formula_id'], 'formula_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raks');
    }
}
