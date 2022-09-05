<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyusutansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyusutans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('keterangan')->nullable();
            $table->integer('susutable_id')->nullable();
            $table->string('susutable_type')->nullable();
            $table->integer('nilai')->nullable();
            $table->bigInteger('ringkasan_penyusutan_id')->nullable()->index('ringkasan_penyusutan_id');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['susutable_id', 'susutable_type'], 'susutable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyusutans');
    }
}
