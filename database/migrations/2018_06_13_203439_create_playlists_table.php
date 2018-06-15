<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePlaylistsTable
 */
class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->unsignedInteger('song_id');
            $table->unsignedInteger('party_id');
            $table->timestamps();

            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
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
        Schema::dropIfExists('playlists');
    }
}
