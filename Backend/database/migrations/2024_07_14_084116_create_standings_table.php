<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->integer('league_id')->nullable();
            $table->integer('season')->nullable();
            $table->integer('team_id')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('points')->nullable();
            $table->integer('goalsDiff')->nullable();
            $table->string('group')->nullable();
            $table->string('form')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->json('all')->nullable();
            $table->json('home')->nullable();
            $table->json('away')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
