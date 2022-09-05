<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianKasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_kasirs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id_2');
            $table->time('jam');
            $table->date('tanggal');
            $table->tinyInteger('dipanggil')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['periksa_id'], 'periksa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian_kasirs');
    }
}
