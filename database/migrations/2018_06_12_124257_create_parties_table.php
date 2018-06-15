<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePartiesTable
 */
class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->timestamp('date');
            $table->float('duration');
            $table->integer('capacity');
            $table->string('description', 255);
            $table->string('tags', 120);
            $table->integer('updated_by');
            $table->boolean('start');
            $table->string('cover_image', 255);
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
        Schema::dropIfExists('parties');
    }
}
