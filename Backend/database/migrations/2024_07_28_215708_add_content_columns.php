<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('content_vi')->nullable();
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('content_vi')->nullable();
        });
        Schema::table('players', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('content_vi')->nullable();
        });
        Schema::table('leagues', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('content_vi')->nullable();
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('content_vi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('content_vi');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('content_vi');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('content_vi');
        });
        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('content_vi');
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('content_vi');
        });
    }
};
