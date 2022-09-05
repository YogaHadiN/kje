<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienProlanisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien_prolanis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id');
            $table->bigInteger('prolanis_id')->nullable()->index('prolanis_id');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['pasien_id', 'prolanis_id'], 'index_pasien_prolanis');
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
        Schema::dropIfExists('pasien_prolanis');
    }
}
