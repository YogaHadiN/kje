<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generiks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('generik');
            $table->string('pregnancy_safety_index')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('peroral')->nullable();
            $table->string('parenteral')->nullable();
            $table->string('topical')->nullable();
            $table->string('opthalmic')->nullable();
            $table->string('vaginal')->nullable();
            $table->string('inhalation')->nullable();
            $table->string('lingual')->nullable();
            $table->string('transdermal')->nullable();
            $table->string('nasal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generiks');
    }
}
