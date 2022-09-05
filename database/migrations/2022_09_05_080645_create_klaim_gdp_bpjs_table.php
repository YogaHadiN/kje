<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlaimGdpBpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klaim_gdp_bpjs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nama_file');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id_2');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
        Schema::dropIfExists('klaim_gdp_bpjs');
    }
}
