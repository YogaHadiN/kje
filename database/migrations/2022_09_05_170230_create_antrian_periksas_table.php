<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_periksas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('asuransi_id')->nullable()->index();
            $table->bigInteger('poli_id')->nullable()->index();
            $table->bigInteger('pasien_id')->nullable()->index();
            $table->bigInteger('staf_id')->nullable()->index();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('hamil')->nullable();
            $table->integer('menyusui')->nullable();
            $table->string('riwayat_alergi_obat')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('suhu')->nullable();
            $table->string('berat_badan')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('perujuk_id')->nullable();
            $table->bigInteger('asisten_id')->nullable()->index();
            $table->text('periksa_awal')->nullable();
            $table->integer('g')->nullable();
            $table->integer('p')->nullable();
            $table->integer('a')->nullable();
            $table->date('hpht')->nullable();
            $table->integer('kecelakaan_kerja')->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->integer('bukan_peserta')->nullable()->default(0);
            $table->integer('sistolik')->nullable();
            $table->integer('diastolik')->nullable();
            $table->string('gds', 225)->nullable();
            $table->bigInteger('periksa_id')->nullable()->index();
            $table->tinyInteger('dipanggil')->nullable()->default(0);
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
        Schema::dropIfExists('antrian_periksas');
    }
}
