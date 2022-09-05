<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliAntriansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poli_antrians', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('jenis_antrian_id')->nullable()->index('jenis_antrian_id');
            $table->bigInteger('poli_id')->nullable()->index('poli_id_2');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['poli_id'], 'poli_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poli_antrians');
    }
}
