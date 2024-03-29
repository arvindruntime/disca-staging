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
            $table->string('phone_dial_code', 10)->after('mobile_no')->nullable();
            $table->string('phone_no', 15)->after('phone_dial_code')->nullable();
            $table->string('otp', 15)->after('sectore')->nullable();

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
            $table->dropColumn('phone_dial_code');
            $table->dropColumn('phone_no');
            $table->dropColumn('otp');
        });
    }
};
