<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekenings', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('akun_bank_id');
            $table->dateTime('tanggal');
            $table->text('deskripsi');
            $table->double('nilai', 20, 2)->nullable();
            $table->double('saldo_akhir', 20, 2)->nullable();
            $table->tinyInteger('debet')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('pembayaran_asuransi_id')->nullable();
            $table->string('kode_transaksi');
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
        Schema::dropIfExists('rekenings');
    }
}
