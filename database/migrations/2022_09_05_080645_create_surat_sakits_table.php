<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratSakitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_sakits', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->date('tanggal_mulai');
            $table->integer('hari');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['periksa_id'], 'periksa_id_2');
            $table->index(['periksa_id'], 'index_periksa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_sakits');
    }
}
