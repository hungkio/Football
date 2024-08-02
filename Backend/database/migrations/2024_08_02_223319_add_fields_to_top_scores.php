<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('top_scores', function (Blueprint $table) {
            $table->integer('goals')->nullable();
            $table->integer('penalty')->nullable();
            $table->integer('team_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('top_scores', function (Blueprint $table) {
            $table->dropColumn('goals');
            $table->dropColumn('penalty');
            $table->dropColumn('team_id');
        });
    }
};
