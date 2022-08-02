<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenolongPersalinansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penolong_persalinans', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('penolong_persalinan');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penolong_persalinans');
    }
}
