<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username');
            $table->integer('role_id')->nullable();
            $table->string('password');
            $table->string('email');
            $table->rememberToken()->nullable(false);
            $table->integer('aktif')->nullable()->default(0);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->string('surveyable_type')->nullable();
            $table->bigInteger('surveyable_id')->nullable()->index('surveyable_id_2');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['surveyable_id', 'surveyable_type'], 'surveyable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
