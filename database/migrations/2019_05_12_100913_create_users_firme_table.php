<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersFirmeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_firme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume')->nullable();
            $table->string('punc_lucru')->nullable();
            $table->string('cif')->nullable();
            $table->string('nr_orc')->nullable();
            $table->string('persoana_contact')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_firme');
    }
}
