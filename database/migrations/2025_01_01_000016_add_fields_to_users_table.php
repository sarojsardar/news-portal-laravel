<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo', 255)->nullable()->after('password');
            $table->string('token', 100)->nullable()->after('photo');
            $table->text('bio')->nullable()->after('token');
            $table->json('social_links')->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('social_links');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'token', 'bio', 'social_links', 'is_active']);
        });
    }
};