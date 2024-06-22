<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('internal_links', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('internal_links');
    }
};
