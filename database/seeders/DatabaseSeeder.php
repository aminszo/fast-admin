<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // [amin] we have called UsersTableSeeder here so in `php artisan db:seed` it will execute.
        $this->call(UsersTableSeeder::class);
    }
}
