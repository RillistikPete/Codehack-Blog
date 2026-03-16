<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            //You must add the unsigned to the foreign key field because the integer field
            // is defined as signed and the foreign key could give you some error relating these two tables.
            // Make sure these constraints are identical with foreign keys.
            $table->integer('post_id')->unsigned()->index()->nullable();
            $table->integer('is_active')->default(0);
            $table->string('author');
            $table->string('email');
            $table->string('photo');
            $table->text('body');
            $table->timestamps();

            //So this deletes all comments on a post if that post is deleted!
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
