<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalUmumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_umums', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('jurnalable_id')->nullable()->index('jurnalable_id_2');
            $table->integer('debit');
            $table->bigInteger('nilai')->nullable();
            $table->bigInteger('coa_id')->nullable()->index('idx_coa_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('jurnalable_type');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['coa_id'], 'coa_id_3');
            $table->index(['coa_id'], 'coa_id');
            $table->index(['jurnalable_id', 'jurnalable_type'], 'jurnalable_id');
            $table->index(['jurnalable_id', 'jurnalable_type'], 'jurnal_index');
            $table->index(['coa_id'], 'coa_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnal_umums');
    }
}
