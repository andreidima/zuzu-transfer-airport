<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Rezervare;
use Faker\Generator as Faker;
use App\Cursa;
use App\OrasStatie;
use Carbon\Carbon;
use App\CursaOra;

$factory->define(Rezervare::class, function (Faker $faker) {
    $cursa_id = Cursa::all()->random()->id;
    $cursa = Cursa::all()->where('id', $cursa_id);
    $oras_id = App\Cursa::select('plecare_id')
        ->where('id', $cursa_id)->first()->plecare_id;
    $ora = CursaOra::all()
            ->where('cursa_id', $cursa_id)
            ->random();
    $nr_adulti = $faker->numberBetween(1 ,3);
    $nr_copii = $faker->numberBetween(0 ,2);
    $pret_total = ($cursa->first()->pret_adult * $nr_adulti) + ($cursa->first()->pret_copil * $nr_copii); 
    // $ora_zbor = \Carbon\Carbon::parse($ora->ora)
    //             ->addMinutes(rand(60, 120))
    //             ->format('H:i');
    

    return[
        'cursa_id' => $cursa_id,        
        'statie_id' => OrasStatie::select('id')
            ->where('oras_id', $oras_id)
            ->get()
            ->random(),
        'data_cursa' => Carbon::today()
            ->addDays(rand(0, 1)),
            // ->addHours(\Carbon\Carbon::parse($ora_plecare)->hour)
            // ->addMinutes(\Carbon\Carbon::parse($ora_plecare)->minute),
        'ora_id' => $ora->id,
        // 'ora_zbor' => $ora_zbor,
        'nume' => $faker->name,
        'telefon' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'nr_adulti' => $nr_adulti,
        'nr_copii' => $nr_copii,
        'pret_total' => $pret_total,
        'observatii' => $faker->boolean(75) ? null : $faker->sentence($nbWords = 6, $variableNbWords = true),
        'comision_agentie' => $pret_total / 10,
        'tip_plata_id' => $faker->numberBetween(1,3),
        'user_id' => '298',
        'status' => $faker->boolean(33) ? null : $faker->randomElement(['0','1'])
    ];
});
