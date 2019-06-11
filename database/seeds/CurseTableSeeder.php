<?php

use Illuminate\Database\Seeder;

class CurseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('curse')->insert([
            [
                'plecare_id' => '11',
                'sosire_id' => '8',
                'durata' => '04:00',
                'pret_adult' => '80',
                'pret_copil' => '40',
                'pret_adult_retur' => '40',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '4',
                'sosire_id' => '8',
                'durata' => '03:00',
                'pret_adult' => '60',
                'pret_copil' => '30',
                'pret_adult_retur' => '30',
                'pret_copil_retur' => '15',
            ],
            [
                'plecare_id' => '10',
                'sosire_id' => '8',
                'durata' => '02:30',
                'pret_adult' => '50',
                'pret_copil' => '25',
                'pret_adult_retur' => '25',
                'pret_copil_retur' => '15',
            ],
            [
                'plecare_id' => '3',
                'sosire_id' => '8',
                'durata' => '02:00',
                'pret_adult' => '40',
                'pret_copil' => '20',
                'pret_adult_retur' => '20',
                'pret_copil_retur' => '10',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '3',
                'durata' => '02:00',
                'pret_adult' => '40',
                'pret_copil' => '20',
                'pret_adult_retur' => '20',
                'pret_copil_retur' => '10',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '10',
                'durata' => '02:30',
                'pret_adult' => '50',
                'pret_copil' => '25',
                'pret_adult_retur' => '25',
                'pret_copil_retur' => '15',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '4',
                'durata' => '03:00',
                'pret_adult' => '60',
                'pret_copil' => '30',
                'pret_adult_retur' => '30',
                'pret_copil_retur' => '15',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '11',
                'durata' => '04:00',
                'pret_adult' => '80',
                'pret_copil' => '40',
                'pret_adult_retur' => '40',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '5',
                'sosire_id' => '8',
                'durata' => '04:00',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '2',
                'sosire_id' => '8',
                'durata' => '03:30',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '6',
                'sosire_id' => '8',
                'durata' => '03:00',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '3',
                'sosire_id' => '8',
                'durata' => '02:00',
                'pret_adult' => '40',
                'pret_copil' => '20',
                'pret_adult_retur' => '20',
                'pret_copil_retur' => '10',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '3',
                'durata' => '02:00',
                'pret_adult' => '40',
                'pret_copil' => '20',
                'pret_adult_retur' => '20',
                'pret_copil_retur' => '10',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '6',
                'durata' => '03:00',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '2',
                'durata' => '03:30',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
            [
                'plecare_id' => '8',
                'sosire_id' => '5',
                'durata' => '04:00',
                'pret_adult' => '70',
                'pret_copil' => '40',
                'pret_adult_retur' => '35',
                'pret_copil_retur' => '20',
            ],
        ]);
    }
}
