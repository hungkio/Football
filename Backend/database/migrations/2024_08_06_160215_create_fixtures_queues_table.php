<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fixtures_queues', function (Blueprint $table) {
            $table->id();
            $table->integer('fixture_id');
            $table->integer('team_id');
            $table->boolean('is_crawled')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fixtures_queues');
    }
};
