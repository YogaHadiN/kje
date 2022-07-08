<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterAncsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_ancs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('periksa_id')->nullable();
            $table->integer('register_hamil_id')->nullable();
            $table->string('td')->nullable();
            $table->string('tfu')->nullable();
            $table->string('lila')->nullable();
            $table->string('bb')->nullable();
            $table->string('refleks_patela_id')->nullable();
            $table->integer('djj')->nullable();
            $table->integer('kepala_terhadap_pap_id')->nullable();
            $table->integer('jumlah_janin')->nullable();
            $table->integer('presentasi_id')->nullable();
            $table->date('hpht')->nullable();
            $table->integer('catat_di_kia')->nullable();
            $table->integer('inj_tt')->nullable();
            $table->integer('fe_tablet')->nullable();
            $table->integer('periksa_hb')->nullable();
            $table->integer('protein_urin')->nullable();
            $table->integer('gula_darah')->nullable();
            $table->integer('thalasemia')->nullable();
            $table->integer('sifilis')->nullable();
            $table->integer('hbsag')->nullable();
            $table->integer('pmtct_konseling')->nullable();
            $table->integer('pmtct_periksa_darah')->nullable();
            $table->integer('pmtct_serologi')->nullable();
            $table->integer('pmtct_arv')->nullable();
            $table->integer('malaria_periksa_darah')->nullable();
            $table->integer('malaria_positif')->nullable();
            $table->integer('malaria_dikasih_obat')->nullable();
            $table->integer('malaria_dikasih_kelambu')->nullable();
            $table->integer('tbc_periksa_dahak')->nullable();
            $table->integer('tbc_positif')->nullable();
            $table->integer('tbc_dikasih_obat')->nullable();
            $table->integer('komplikasi_hdk')->nullable();
            $table->integer('komplikasi_abortus')->nullable();
            $table->integer('komplikasi_perdarahan')->nullable();
            $table->integer('komplikasi_infeksi')->nullable();
            $table->integer('komplikasi_kpd')->nullable();
            $table->string('komplikasi_lain_lain')->nullable();
            $table->integer('rujukan_puskesmas')->nullable();
            $table->integer('rujukan_RB')->nullable();
            $table->integer('rujukan_RSIA_RSB')->nullable();
            $table->integer('rujukan_RS')->nullable();
            $table->string('rujukan_lain')->nullable();
            $table->string('rujukan_tiba_masih_hidup')->nullable();
            $table->string('rujukan_tiba_meninggal')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
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
        Schema::dropIfExists('register_ancs');
    }
}
