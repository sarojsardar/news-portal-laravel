<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['banner', 'popup', 'sidebar', 'inline']);
            $table->enum('position', ['top', 'bottom', 'left', 'right', 'center']);
            $table->text('content'); // HTML, image path, or ad code
            $table->string('url', 500)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type', 'position', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
};