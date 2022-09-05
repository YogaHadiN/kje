<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alergies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id_2');
            $table->bigInteger('generik_id')->nullable()->index('generik_id');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['pasien_id'], 'pasien_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alergies');
    }
}
