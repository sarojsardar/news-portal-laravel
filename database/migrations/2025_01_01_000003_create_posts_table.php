<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300);
            $table->string('slug', 300)->unique();
            $table->string('subtitle', 300)->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->enum('type', ['article', 'video', 'gallery', 'poll', 'live'])->default('article');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('featured_image', 255)->nullable();
            $table->json('meta_data')->nullable(); 
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('language_id')->constrained();
            $table->timestamps();
            
            $table->index(['status', 'published_at']);
            $table->index(['type', 'status']);
            $table->index(['is_featured', 'published_at']);
            $table->fullText(['title', 'content']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};