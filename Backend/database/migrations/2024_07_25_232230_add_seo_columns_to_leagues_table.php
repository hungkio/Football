<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leagues', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_title_vi')->nullable();
            $table->string('meta_description_vi')->nullable();
            $table->string('meta_keywords_vi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_title_vi');
            $table->dropColumn('meta_description_vi');
            $table->dropColumn('meta_keywords_vi');
        });
    }
};
