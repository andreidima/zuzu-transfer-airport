<?php

use Illuminate\Database\Seeder;

class OraseStatiiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orase_statii')->insert([
            [
                'oras_id' => '1',
                'nume' => 'Lukoil',
            ],
            [
                'oras_id' => '2',
                'nume' => 'Catedrala la covrigăria Panda',
            ],
            [
                'oras_id' => '2',
                'nume' => 'Penny pe Bz-ului',
            ],
            [
                'oras_id' => '2',
                'nume' => 'Plantelor',
            ],
            [
                'oras_id' => '3',
                'nume' => 'McDonald`s- Km0',
            ],
            [
                'oras_id' => '4',
                'nume' => 'Lidl fosta Autogară',
            ],
            [
                'oras_id' => '4',
                'nume' => 'Lukoil Centru',
            ],
            [
                'oras_id' => '5',
                'nume' => 'McDonald`s',
            ],
            [
                'oras_id' => '6',
                'nume' => 'Avion',
            ],
            [
                'oras_id' => '7',
                'nume' => 'Gară',
            ],
            [
                'oras_id' => '8',
                'nume' => 'Otopeni',
            ],
            [
                'oras_id' => '9',
                'nume' => 'Notar',
            ],
            [
                'oras_id' => '10',
                'nume' => 'Turist-Profi',
            ],
            [
                'oras_id' => '11',
                'nume' => 'Kaufland',
            ],
            [
                'oras_id' => '12',
                'nume' => 'Vaslui',
            ],
        ]);
    }
}
