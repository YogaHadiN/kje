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
            $table->bigInteger('supplier_id')->nullable()->index('supplier_id');
            $table->boolean('submit')->default(false);
            $table->string('nomor_faktur');
            $table->integer('belanja_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('sumber_uang_id')->nullable()->index('sumber_uang_id');
            $table->string('faktur_image')->nullable();
            $table->bigInteger('petugas_id')->nullable()->index('petugas_id');
            $table->integer('diskon')->default(0);
            $table->bigInteger('tenant_id')->index();
            $table->string('bukti_transfer')->nullable();
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
