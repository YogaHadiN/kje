<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_tarifs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('jenis_tarif');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('tipe_laporan_admedika_id')->nullable()->default(0);
            $table->integer('tipe_laporan_kasir_id')->nullable()->default(0);
            $table->integer('coa_id');
            $table->integer('dengan_asisten')->nullable()->default(0);
            $table->integer('murni_jasa_dokter');
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
        Schema::dropIfExists('jenis_tarifs');
    }
}
