<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaBelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_belis', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('nomor_faktur')->nullable();
            $table->date('tanggal');
            $table->bigInteger('staf_id')->nullable()->index('staf_id');
            $table->bigInteger('supplier_id')->nullable()->index('supplier_id');
            $table->integer('jumlah');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');

            $table->index(['staf_id'], 'staf_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_belis');
    }
}
