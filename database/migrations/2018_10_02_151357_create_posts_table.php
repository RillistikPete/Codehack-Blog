<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable()->default(0);
            $table->integer('photo_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->text('body');
            $table->string('slug')->nullable();
            $table->timestamps();
            // Foreign key constraints are used to force referential
            // integrity at the database level.
            // This will delete the posts for a user if the user is deleted!
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
