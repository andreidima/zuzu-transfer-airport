<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursaOraTraseuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursa_ora_traseu', function (Blueprint $table) {
            $table->primary(['cursa_ora_id', 'traseu_id']);
            $table->unsignedBigInteger('cursa_ora_id');
            $table->unsignedBigInteger('traseu_id');
            $table->timestamps();

            $table->foreign('cursa_ora_id')->references('id')->on('curse_ore')->onDelete('cascade');
            $table->foreign('traseu_id')->references('id')->on('trasee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursa_ora_traseu');
    }
}
