<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asuransis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nama');
            $table->mediumText('alamat')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('tipe_asuransi');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->double('kali_obat')->nullable();
            $table->string('coa_id')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->tinyInteger('aktif')->default(1);
            $table->integer('pelunasan_tunai')->nullable()->default(0);
            $table->integer('new_id')->nullable();
            $table->string('old_id')->nullable();
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
        Schema::dropIfExists('asuransis');
    }
}
