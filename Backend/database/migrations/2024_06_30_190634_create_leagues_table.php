<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('logo')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('leagues');
    }
};
