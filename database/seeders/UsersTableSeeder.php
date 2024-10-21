<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /*
     * [amin] this seeder adds a preregistered user, so we don't need to use register form to create first user.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'amin',
            'email' => 'vitaminboook.ir@gmail.com',
            'password' => '$2y$10$6hWTFd7D9XJO0A/wuN0oYO3uI739iO/OYFntz0dD.K1wop6MvfImy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
