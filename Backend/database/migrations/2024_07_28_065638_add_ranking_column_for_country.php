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
        Schema::table('countries', function (Blueprint $table) {
            $table->string('rank')->nullable();
            $table->string('previous_rank')->nullable();
            $table->string('points')->nullable();
            $table->string('previous_points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            //
            $table->dropColumn('rank');
            $table->dropColumn('previous_rank');
            $table->dropColumn('points');
            $table->dropColumn('previous_points');
        });
    }
};
