<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProlanisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prolanis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('usia');
            $table->string('alamat');
            $table->string('no')->nullable();
            $table->string('prolanis');
            $table->date('periode');
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
        Schema::dropIfExists('prolanis');
    }
}
