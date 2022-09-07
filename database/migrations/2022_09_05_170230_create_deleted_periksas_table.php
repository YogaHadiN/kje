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
            $table->bigInteger('pasien_id')->nullable()->index();
            $table->bigInteger('periksa_id')->nullable()->index();
            $table->bigInteger('staf_id')->nullable()->index();
            $table->bigInteger('kabur_id')->nullable()->index();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index();

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
