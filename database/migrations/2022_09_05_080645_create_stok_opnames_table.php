<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('rak_id')->nullable()->index('rak_id');
            $table->integer('stok_komputer')->nullable();
            $table->integer('stok_fisik')->nullable();
            $table->date('exp_date')->nullable();
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
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
        Schema::dropIfExists('stok_opnames');
    }
}
