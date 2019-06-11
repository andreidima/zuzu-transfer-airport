<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'andrei',
            'nume' => 'Zuzu Transfer Aeroport',
            'email' => 'zuzu@gmail.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
