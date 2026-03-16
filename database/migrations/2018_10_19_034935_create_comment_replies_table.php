<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->unsigned()->index()->nullable();
            $table->integer('is_active')->default(0);
            $table->string('author');
            $table->string('email');
            $table->string('photo');
            $table->text('body');
            $table->timestamps();

            //So this deletes all replies on a comment if that comment is deleted!
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_replies');
    }
}
