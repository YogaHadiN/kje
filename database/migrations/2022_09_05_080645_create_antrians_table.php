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
            $table->bigInteger('jenis_antrian_id')->nullable()->index('jenis_antrian_id');
            $table->string('url')->nullable();
            $table->integer('nomor')->nullable();
            $table->bigInteger('antriable_id')->nullable()->index('index_antriable_id');
            $table->string('antriable_type', 30)->nullable()->index('index_antriable_type');
            $table->bigInteger('whatsapp_registration_id')->nullable()->index('whatsapp_registration_id');
            $table->tinyInteger('dipanggil')->nullable()->default(0);
            $table->string('no_telp')->nullable();
            $table->string('nama')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->bigInteger('tenant_id')->index();
            $table->string('kode_unik', 5);
            $table->integer('registrasi_pembayaran_id')->nullable();
            $table->string('nomor_bpjs')->nullable();
            $table->integer('satisfaction_index')->nullable();

            $table->index(['antriable_id', 'antriable_type'], 'antriable_id');
            $table->index(['antriable_id'], 'antriable_id_2');
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
