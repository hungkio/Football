<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('content');
            $table->integer('post_id')->nullable();
            $table->integer('news_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('comments');
    }
};
