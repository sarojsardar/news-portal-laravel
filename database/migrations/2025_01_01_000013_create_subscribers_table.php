<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->string('name', 100)->nullable();
            $table->json('preferences')->nullable(); // categories, frequency
            $table->enum('status', ['active', 'pending', 'unsubscribed'])->default('pending');
            $table->string('verification_token', 64)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
};