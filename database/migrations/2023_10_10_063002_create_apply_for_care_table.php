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
        Schema::create('apply_for_care', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_name');
            $table->string('apply_person_name');
            $table->string('relationship');
            $table->string('street');
            $table->string('city');
            $table->string('country');
            $table->string('post_code');
            $table->string('email');
            $table->string('telephone');
            $table->string('mobile_number');
            $table->string('required_care');
            $table->longText('description');
            $table->longText('specialist_care');
            $table->boolean('term_condition')->comment('0=>unchecked,1=>checked')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('apply_for_care');
    }
};
