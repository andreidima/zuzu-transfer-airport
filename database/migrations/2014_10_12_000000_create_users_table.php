<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_role_id')->nullable();
            $table->unsignedBigInteger('user_firma_id')->nullable();
            $table->string('username')->unique();
            $table->string('nume')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->unique()->nullable();
            $table->text('observatii')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->foreign('user_firma_id')->references('id')->on('users_firme');
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
