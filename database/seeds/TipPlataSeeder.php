<?php

use Illuminate\Database\Seeder;

class TipPlataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tip_plata')->insert([
            ['nume' => 'Șofer'],
            ['nume' => 'Agenție'],
            ['nume' => 'Card'],
        ]);
    }
}
