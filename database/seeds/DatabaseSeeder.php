<?php

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
        $this->call([
            // UsersTableSeeder::class,


            // TraseeNumeTableSeeder::class,
            // TraseeTableSeeder::class,
            // OraseTableSeeder::class,
            // OraseStatiiTableSeeder::class,
            // CurseTableSeeder::class,
            // CurseOreTableSeeder::class,
            // CurseOreTraseeTableSeeder::class,
            // TipPlataSeeder::class,
        ]);

        factory('App\Rezervare', 1500)->create();
    }
}
