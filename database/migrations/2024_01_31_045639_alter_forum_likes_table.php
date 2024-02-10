<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // forum_id
        Schema::table('forum_likes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->dropForeign(['topic_id']);
            $table->foreign('topic_id')->references('id')->on('forum_topics')->onUpdate('cascade')->onDelete('cascade');
            $table->dropForeign(['topic_comment_id']);
            $table->foreign('topic_comment_id')->references('id')->on('topic_comments')->onUpdate('cascade')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
