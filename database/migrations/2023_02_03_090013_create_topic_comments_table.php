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
        Schema::create('topic_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('topic_comments')->onDelete('cascade');
            $table->longText('comment_text');
            $table->foreignId('forum_board_id')->constrained('forum_board')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('topicommentable_id');
            $table->string('topicommentable_type');
            $table->foreignId('commented_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('topic_comments');
    }
};
