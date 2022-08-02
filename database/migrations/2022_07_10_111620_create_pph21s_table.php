<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePph21sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pph21s', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('pph21able_id');
            $table->string('pph21able_type');
            $table->integer('pph21');
            $table->integer('menikah');
            $table->integer('punya_npwp');
            $table->integer('jumlah_anak');
            $table->integer('ptkp_dasar');
            $table->integer('ptkp_setahun');
            $table->integer('penghasilan_kena_pajak_setahun');
            $table->integer('biaya_jabatan');
            $table->integer('gaji_netto');
            $table->integer('gaji_bruto');
            $table->integer('potongan5persen_setahun');
            $table->integer('potongan15persen_setahun');
            $table->integer('potongan25persen_setahun');
            $table->integer('potongan30persen_setahun');
            $table->integer('pph21_setahun');
            $table->text('ikhtisar_gaji_bruto');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
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
        Schema::dropIfExists('pph21s');
    }
}
