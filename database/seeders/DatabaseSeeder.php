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
        $this->run_seeders();
//         \App\Models\User::factory(10)->create();
    }

    private function run_seeders()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
