<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_periksas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id');
            $table->bigInteger('kabur_id')->nullable()->index('kabur_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['staf_id'], 'staf_id_2');
            $table->index(['periksa_id'], 'periksa_id_2');
            $table->index(['pasien_id'], 'pasien_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_periksas');
    }
}
