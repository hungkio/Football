<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('country')->nullable();
            $table->boolean('national')->nullable();
            $table->string('logo')->nullable();
            $table->integer('league_id')->nullable();
            $table->integer('season')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('teams');
    }
};
