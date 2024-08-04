<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tool_redirecters', function (Blueprint $table) {
            $table->id();
            $table->string('origin_link');
            $table->string('redirect_link');
            $table->string('status')->comment('1 active | 0 inactive')->default(1);
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->timestamps();
        });

        Schema::create('tool_auto_link', function (Blueprint $table) {
            $table->id();
            $table->string('key_word');
            $table->string('redirect_link');
            $table->timestamps();
        });

        Schema::create('tool_meta_seo_link', function (Blueprint $table) {
            $table->id();
            $table->string('redirect_link');
            $table->string('meta_canonical');
            $table->timestamps();
        });
      
        Schema::create('tool_meta_seo_link_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('meta_seo_link_id');
            $table->string('lang');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->string('content_header');
            $table->string('content_footer');
            $table->timestamps();
        });

        Schema::create('tool_text_seo_footer', function (Blueprint $table) {
            $table->id();
            $table->string('redirect_link');
            $table->string('meta_canonical');
            $table->string('status')->comment('1 active | 0 inactive')->default(1);
            $table->timestamps();
        });
      
        Schema::create('tool_text_seo_footer_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('text_seo_footer_id');
            $table->string('name');
            $table->string('lang');
            $table->string('content');
            $table->timestamps();
        });
    }

    public function down()
    {
         Schema::dropIfExists('tool_redirecters');
         Schema::dropIfExists('tool_auto_link');
         Schema::dropIfExists('tool_meta_seo_link');
         Schema::dropIfExists('tool_meta_seo_link_transaction');
         Schema::dropIfExists('tool_text_seo_footer');
         Schema::dropIfExists('tool_text_seo_footer_transaction');
    }
};
