<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->longText('content');
            $table->json('seo_meta')->nullable(); // title, description, keywords
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_menu')->default(false);
            $table->unsignedTinyInteger('menu_order')->default(0);
            $table->foreignId('language_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};