<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_telp');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('antrian_id')->nullable()->index('antrian_id');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('nama')->nullable();
            $table->integer('registrasi_pembayaran_id')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('registering_confirmation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_registrations');
    }
}
