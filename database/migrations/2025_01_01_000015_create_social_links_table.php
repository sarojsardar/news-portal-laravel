<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 50); // facebook, twitter, instagram, etc.
            $table->string('url', 200);
            $table->string('icon', 50)->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_links');
    }
};