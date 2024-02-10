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
        Schema::create('forum_board_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('forum_board_id')->nullable()->constrained('forum_board')->onUpdate('cascade')->onDelete('cascade');
            //$table->bigInteger('topic_id')->nullable();
            $table->foreignId('topic_id')->nullable()->constrained('forum_topics')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('followers')->nullable();
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
        Schema::dropIfExists('forum_board_activities');
    }
};
