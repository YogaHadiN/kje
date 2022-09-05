<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKabursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaburs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id_2');
            $table->string('alasan')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('staf_id')->nullable()->index('staf_id');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['staf_id'], 'staf_id_2');
            $table->index(['pasien_id'], 'pasien_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kaburs');
    }
}
