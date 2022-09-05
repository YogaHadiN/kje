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
            $table->bigInteger('akun_bank_id')->nullable()->index('akun_bank_id');
            $table->dateTime('tanggal');
            $table->text('deskripsi');
            $table->double('nilai', 20, 2)->nullable();
            $table->double('saldo_akhir', 20, 2)->nullable();
            $table->tinyInteger('debet')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('pembayaran_asuransi_id')->nullable()->index('pembayaran_asuransi_id');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('kode_transaksi')->index('kode_transaksi');

            $table->index(['akun_bank_id'], 'akun_bank_id_2');
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
