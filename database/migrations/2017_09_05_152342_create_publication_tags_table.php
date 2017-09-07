<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag');
            $table->integer('publication_id')->unsigned();

            $table->foreign('publication_id')->references('id')->on('publications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication_tags');
    }
}
