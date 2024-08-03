<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('live_fixtures');
        Schema::create('live_fixtures', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id');
            $table->string('referee')->nullable();
            $table->string('timezone')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('timestamp')->nullable();
            $table->json('periods')->nullable();
            $table->json('venue')->nullable();
            $table->json('status')->nullable();
            $table->json('league')->nullable();
            $table->json('teams')->nullable();
            $table->json('goals')->nullable();
            $table->json('score')->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('live_fixtures');
    }
};
