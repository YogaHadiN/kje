<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutKasirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_kasirs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('modal_awal')->nullable();
            $table->integer('uang_keluar')->nullable();
            $table->integer('uang_masuk')->nullable();
            $table->integer('debit')->nullable();
            $table->integer('jurnal_umum_id')->nullable();
            $table->integer('uang_di_kasir')->nullable();
            $table->integer('uang_di_tangan')->nullable();
            $table->text('detil_pengeluarans')->nullable();
            $table->text('detil_modals')->nullable();
            $table->text('detil_pengeluaran_tangan')->nullable();
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
        Schema::dropIfExists('checkout_kasirs');
    }
}
