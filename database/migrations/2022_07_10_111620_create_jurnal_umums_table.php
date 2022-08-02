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
            $table->string('jurnalable_id');
            $table->integer('debit');
            $table->bigInteger('nilai')->nullable();
            $table->string('coa_id')->nullable()->index();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('jurnalable_type');
            $table->bigInteger('tenant_id')->index();

            $table->index(['jurnalable_id', 'jurnalable_type'], 'jurnal_index');
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
