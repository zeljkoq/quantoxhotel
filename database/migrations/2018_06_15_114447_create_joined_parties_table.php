<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateJoinedPartiesTable
 */
class CreateJoinedPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joined_parties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->unsignedInteger('party_id');
            $table->timestamps();

            $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joined_parties');
    }
}
