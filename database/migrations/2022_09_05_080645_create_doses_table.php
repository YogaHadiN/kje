<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('berat_badan_id')->nullable()->index('berat_badan_id');
            $table->integer('signa_id')->nullable();
            $table->bigInteger('formula_id')->nullable()->index('formula_id_2');
            $table->integer('jumlah')->nullable();
            $table->integer('jumlah_bpjs')->nullable();
            $table->integer('jumlah_puyer_add')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['formula_id'], 'formula_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doses');
    }
}
