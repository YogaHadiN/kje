<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('kirim_berkas_id')->nullable()->index('kirim_berkas_id');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('pembayaran_asuransi_id')->nullable()->index('pembayaran_asuransi_id');
            $table->string('received_verification')->nullable();
            $table->bigInteger('tenant_id')->index();
            $table->string('kode_invoice')->index('kode_invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
