<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporPajaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapor_pajaks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal_lapor')->nullable();
            $table->date('awal_periode')->nullable();
            $table->date('akhir_periode')->nullable();
            $table->string('staf_id', 45);
            $table->string('jenis_pajak_id', 45);
            $table->string('dokumen_dan_bukti', 45);
            $table->integer('nilai');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->bigInteger('tenant_id')->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lapor_pajaks');
    }
}
