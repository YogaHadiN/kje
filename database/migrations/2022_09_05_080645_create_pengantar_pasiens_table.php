<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengantarPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengantar_pasiens', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pengantar_id')->nullable()->index('pengantar_id');
            $table->bigInteger('antarable_id')->nullable()->index('antarable_id_2');
            $table->string('antarable_type')->index('index_antarable_type');
            $table->string('kunjungan_sehat');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('pcare_submit')->default(0);
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['antarable_id', 'antarable_type'], 'antarable_id');
            $table->index(['antarable_id'], 'index_antarable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengantar_pasiens');
    }
}
