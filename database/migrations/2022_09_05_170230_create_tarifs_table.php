<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('jenis_tarif_id')->nullable()->index();
            $table->integer('biaya')->default(0);
            $table->bigInteger('asuransi_id')->nullable()->index();
            $table->integer('jasa_dokter')->default(0);
            $table->bigInteger('tipe_tindakan_id')->nullable()->index();
            $table->mediumText('bhp_items')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('jasa_dokter_tanpa_sip')->nullable();
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
        Schema::dropIfExists('tarifs');
    }
}
