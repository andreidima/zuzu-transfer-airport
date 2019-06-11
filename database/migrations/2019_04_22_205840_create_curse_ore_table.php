<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurseOreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curse_ore', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cursa_id');
            $table->time('ora');
            $table->timestamps();

            $table->foreign('cursa_id')->references('id')->on('curse')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curse_ore');
    }
}
