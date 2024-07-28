<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('slug')->nullable();
        });
        Schema::create('subregions', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('region_id')->nullable();
            $table->string('slug')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regions');
        Schema::dropIfExists('subregions');
    }
};
