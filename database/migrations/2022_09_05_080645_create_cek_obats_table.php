<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_obats', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rak_id')->nullable()->index('rak_id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->integer('jumlah_di_sistem');
            $table->integer('jumlah_di_hitung');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['rak_id'], 'rak_id_2');
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
        Schema::dropIfExists('cek_obats');
    }
}
