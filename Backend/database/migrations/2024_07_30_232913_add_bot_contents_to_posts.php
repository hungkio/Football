<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('players', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('fixtures', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('leagues', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->longText('bot_body')->nullable();
            $table->longText('bot_body_vi')->nullable();
        });
    }

    public function down(){
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });

        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('bot_body');
            $table->dropColumn('bot_body_vi');
        });
    }
};
