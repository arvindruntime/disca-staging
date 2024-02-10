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
        Schema::table('users', function (Blueprint $table) {
            $table->string('fcm_token')->nullable();
            $table->integer('email_status')->default(0)->comment('0 = off, 1 = on');
            $table->integer('notification_status')->default(0)->comment('0 = off, 1 = on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('fcm_token');
            $table->dropColumn('email_status');
            $table->dropColumn('notification_status');
        });
    }
};
