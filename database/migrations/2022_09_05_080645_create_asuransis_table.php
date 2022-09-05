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
            $table->integer('tipe_asuransi_id')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->double('kali_obat')->nullable();
            $table->bigInteger('coa_id')->nullable()->index('coa_id_2');
            $table->string('kata_kunci')->nullable();
            $table->tinyInteger('aktif')->default(1);
            $table->integer('pelunasan_tunai')->nullable()->default(0);
            $table->integer('new_id')->nullable();
            $table->string('old_id')->nullable();
            $table->bigInteger('tenant_id')->index();
            $table->integer('master_template')->nullable()->default(0);

            $table->index(['coa_id'], 'coa_id');
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
