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
            //
            $table->string('region')->nullable();
            $table->string('region_id')->nullable();
            $table->string('subregion')->nullable();
            $table->string('subregion_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            //
            $table->dropColumn('region');
            $table->dropColumn('region_id');
            $table->dropColumn('subregion');
            $table->dropColumn('subregion_id');
        });
    }
};
