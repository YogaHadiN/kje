<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookDaftarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_daftars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pasien_id')->nullable();
            $table->string('nama_pasien')->nullable();
            $table->date('tanggal_lahir_pasien')->default('0000-00-00');
            $table->string('alamat_pasien')->nullable();
            $table->string('no_hp_pasien')->nullable();
            $table->string('email_pasien')->nullable();
            $table->string('gender_id')->nullable();
            $table->string('facebook_id');
            $table->string('pilihan_poli')->nullable();
            $table->integer('pilihan_pembayaran')->nullable();
            $table->integer('verified')->nullable()->default(0);
            $table->integer('pernah_berobat');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
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
        Schema::dropIfExists('facebook_daftars');
    }
}
