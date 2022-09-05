<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatKehamilanSebelumnyasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_kehamilan_sebelumnyas', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id_2');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->integer('jenis_kelamin');
            $table->integer('berat_lahir');
            $table->integer('penolong_persalinan_id');
            $table->integer('cara_persalinan_id');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();

            $table->index(['pasien_id', 'tenant_id'], 'pasien_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_kehamilan_sebelumnyas');
    }
}
