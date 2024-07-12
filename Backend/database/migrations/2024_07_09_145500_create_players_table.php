<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('age')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('injured')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('players');
    }
};
