<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media_attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable'); // post_id, page_id, etc.
            $table->enum('type', ['image', 'video', 'audio', 'document']);
            $table->string('filename', 255);
            $table->string('original_name', 255);
            $table->string('path', 500);
            $table->string('url', 500)->nullable();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->json('metadata')->nullable(); // dimensions, duration, etc.
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_attachments');
    }
};