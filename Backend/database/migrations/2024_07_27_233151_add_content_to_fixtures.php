<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->longText('content')->nullable();
            $table->longText('vi_content')->nullable();
            $table->json('related_posts')->nullable();
        });
        Schema::table('leagues', function (Blueprint $table) {
            $table->string('vi_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('vi_content');
            $table->dropColumn('related_posts');
        });
        Schema::table('leagues', function (Blueprint $table) {
            $table->dropColumn('vi_name');
        });
    }
};
