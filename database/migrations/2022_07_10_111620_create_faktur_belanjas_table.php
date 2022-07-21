<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakturBelanjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faktur_belanjas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->date('tanggal');
            $table->string('supplier_id');
            $table->boolean('submit')->default(false);
            $table->string('nomor_faktur');
            $table->integer('belanja_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('sumber_uang_id')->nullable();
            $table->string('faktur_image');
            $table->string('petugas_id');
            $table->integer('diskon')->default(0);
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
        Schema::dropIfExists('faktur_belanjas');
    }
}
