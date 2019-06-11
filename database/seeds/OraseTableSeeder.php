<?php

use Illuminate\Database\Seeder;

class OraseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orase')->insert([
            ['nume' => 'Adjud',],
            ['nume' => 'Brăila'],
            ['nume' => 'Buzău'],
            ['nume' => 'Focșani'],
            ['nume' => 'Galați'],
            ['nume' => 'Ianca'],
            ['nume' => 'Mărășești'],
            ['nume' => 'Otopeni'],
            ['nume' => 'Panciu'],
            ['nume' => 'Râmnicu Sărat'],
            ['nume' => 'Tecuci'],
            ['nume' => 'Vaslui'],
        ]);
    }
}
