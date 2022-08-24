<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stafs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('nama');
            $table->string('alamat_domisili');
            $table->string('no_telp');
            $table->string('titel');
            $table->string('ktp');
            $table->string('str');
            $table->string('alamat_ktp');
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->string('universitas_asal');
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('aktif')->nullable()->default(1);
            $table->string('image')->nullable();
            $table->string('ktp_image')->nullable();
            $table->string('str_image')->nullable();
            $table->string('sip_image')->nullable();
            $table->integer('menikah')->nullable();
            $table->string('npwp')->nullable();
            $table->integer('jumlah_anak')->nullable()->default(0);
            $table->string('gambar_npwp')->nullable();
            $table->string('sip')->nullable();
            $table->integer('jenis_kelamin')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('bank')->nullable();
            $table->integer('gaji_tetap')->nullable();
            $table->integer('plafon_bpjs')->nullable();
            $table->tinyInteger('owner')->default(0);
            $table->bigInteger('tenant_id')->index();
            $table->string('old_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stafs');
    }
}
