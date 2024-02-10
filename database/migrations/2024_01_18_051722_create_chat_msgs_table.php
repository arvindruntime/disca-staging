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
        Schema::create('chat_msgs', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->text('message')->nullable();
            $table->string('socket_id')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('from');
            $table->integer('status')->default(0);
            $table->string('message_type')->comment('0=> normal, 2 => common')->default(0);
            $table->integer('is_msg_encrypted')->default(0);
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
        Schema::dropIfExists('chat_msgs');
    }
};
