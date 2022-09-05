<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasKirimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_kirims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->bigInteger('role_pengiriman_id')->nullable()->index('role_pengiriman_id');
            $table->bigInteger('kirim_berkas_id')->nullable()->index('kirim_berkas_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['staf_id'], 'staf_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas_kirims');
    }
}
