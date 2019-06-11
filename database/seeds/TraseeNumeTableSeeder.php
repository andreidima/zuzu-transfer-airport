<?php

use Illuminate\Database\Seeder;

class TraseeNumeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trasee_nume')->insert([
            ['nume' => 'Tecuci - Otopeni'],
            ['nume' => 'Otopeni - Tecuci'],
            ['nume' => 'Galați - Otopeni'],
            ['nume' => 'Otopeni - Galați'],
        ]);
    }
}
