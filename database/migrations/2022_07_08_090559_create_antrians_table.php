<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntriansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('jenis_antrian_id')->nullable();
            $table->string('url')->nullable();
            $table->integer('nomor')->nullable();
            $table->string('antriable_id', 30)->nullable()->index('index_antriable_id');
            $table->string('antriable_type', 30)->nullable()->index('index_antriable_type');
            $table->string('whatsapp_registration_id')->nullable();
            $table->string('nomor_bpjs')->nullable();
            $table->tinyInteger('dipanggil')->nullable()->default(0);
            $table->string('no_telp')->nullable();
            $table->string('poli_id')->nullable();
            $table->string('nama_asuransi')->nullable();
            $table->string('nama')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_asuransi')->nullable();
            $table->string('pembayaran')->nullable();
            $table->integer('konfirmasi_nomor_antrian')->nullable();
            $table->text('alamat')->nullable();
            $table->bigInteger('tenant_id')->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrians');
    }
}
