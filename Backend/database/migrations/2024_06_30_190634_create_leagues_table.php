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
            $table->json('league');
            $table->json('country');
            $table->json('seasons');
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('leagues');
    }
};
