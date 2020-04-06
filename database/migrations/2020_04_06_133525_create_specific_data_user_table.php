<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificDataUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_data_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('last_name');
            $table->date('birthday');
            $table->string('number_phone')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address')->nullable();
            $table->string('sex');
            $table->string('terms');
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
        Schema::dropIfExists('specific_data_user');
    }
}
