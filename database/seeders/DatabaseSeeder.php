<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        
        User::create([
            'name' => 'saya user',
            'email' => 'user@user.com',
            'password'=> bcrypt('inipassword123'),
        ]);

        // User ini admin
        User::create([
            'name' => 'saya juga user',
            'email' => 'userjuga@user.com',
            'password'=> bcrypt('inipasswordjuga123'),
        ]);

        Category::create([
            'name' => 'PHP',
            'user_id' => 1
        ]);

        Category::create([
            'name' => 'Javascript',
            'user_id' => 1
        ]);

        Category::create([
            'name' => 'Python',
            'user_id' => 1
        ]);

        Category::create([
            'name' => 'Programming',
            'user_id' => 2
        ]);


        Category::create([
            'name' => 'Design',
            'user_id' => 2
        ]);

        User::factory(3)->create();
        Article::factory(14)->create();
    }
}
