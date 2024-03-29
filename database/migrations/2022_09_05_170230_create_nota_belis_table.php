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
            $table->bigInteger('staf_id')->nullable()->index();
            $table->bigInteger('supplier_id')->nullable()->index();
            $table->integer('jumlah');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index();
            $table->string('old_id')->nullable()->index();

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
