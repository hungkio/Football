<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('player_id');
            $table->integer('team_id');
            $table->integer('league_id');
            $table->json('games')->nullable();
            $table->json('substitutes')->nullable();
            $table->json('shots')->nullable();
            $table->json('goals')->nullable();
            $table->json('passes')->nullable();
            $table->json('tackles')->nullable();
            $table->json('duels')->nullable();
            $table->json('dribbles')->nullable();
            $table->json('fouls')->nullable();
            $table->json('cards')->nullable();
            $table->json('penalty')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('player_statistics');
    }
};
