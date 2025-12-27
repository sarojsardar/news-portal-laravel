<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BasicDataSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@newsportal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create editor user
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@newsportal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $editor->assignRole('editor');

        // Create author user
        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@newsportal.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $author->assignRole('author');

        // Create sample language
        \DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
            'is_default' => true,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample categories
        \DB::table('categories')->insert([
            [
                'name' => 'Politics',
                'slug' => 'politics',
                'description' => 'Political news and updates',
                'color' => '#FF5733',
                'sort_order' => 1,
                'language_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports news and events',
                'color' => '#33FF57',
                'sort_order' => 2,
                'language_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Tech news and innovations',
                'color' => '#3357FF',
                'sort_order' => 3,
                'language_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create sample settings
        $settings = [
            ['key' => 'site_name', 'value' => 'News Portal', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Your trusted news source', 'type' => 'string', 'group' => 'general'],
            ['key' => 'posts_per_page', 'value' => '10', 'type' => 'integer', 'group' => 'content'],
            ['key' => 'allow_comments', 'value' => 'true', 'type' => 'boolean', 'group' => 'content'],
        ];

        foreach ($settings as $setting) {
            \DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}