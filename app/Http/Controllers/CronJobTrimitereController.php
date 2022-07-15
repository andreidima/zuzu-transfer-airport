<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Masina;
use App\Sofer;
use Carbon\Carbon;

use App\Traits\TrimiteSmsTrait;

class CronJobTrimitereController extends Controller
{
    use TrimiteSmsTrait;

    public function trimitere($key = null)
    {
        $config_key = \Config::get('variabile.cron_job_key');
        // dd($key, $config_key);

        if ($key === $config_key){
            $mesaj_per_total = '';

            $masini = Masina::all();
            $soferi = Sofer::all();

            // Se calculeaza zilele ramase pana la data din DB. Valoarea poate fi negativa daca a trecut deja data
            // Se verifica daca mai sunt 15 zile pana la data din DB, daca mai sunt maxim 5 zile, sau daca deja a trecut data din DB.

            foreach ($masini as $masina) {
                $mesaj_per_masina = '';
                if($masina->itp) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->itp, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'ITP ' . Carbon::parse($masina->itp)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->asigurare_rca) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->asigurare_rca, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'RCA ' . Carbon::parse($masina->asigurare_rca)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->asigurari_persoane_colete) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->asigurari_persoane_colete, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Asigurari persoane colete ' . Carbon::parse($masina->asigurari_persoane_colete)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->copie_conforma) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->copie_conforma, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Copie conforma ' . Carbon::parse($masina->copie_conforma)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->clasificare) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->clasificare, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Clasificare ' . Carbon::parse($masina->clasificare)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->verificare_tahograf) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->verificare_tahograf, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Verificare tahograf ' . Carbon::parse($masina->verificare_tahograf)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->rovinieta_romania) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->rovinieta_romania, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Rovinieta Romania ' . Carbon::parse($masina->rovinieta_romania)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->revizie) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->revizie, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_masina .= 'Revizie ' . Carbon::parse($masina->revizie)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }

                if ($mesaj_per_masina) {
                    $mesaj_per_masina = substr($mesaj_per_masina, 0, -2); // stergerea ultimelor 2 caractere ", "
                    $mesaj_per_total .= 'Masina ' . $masina->nume . ': ' . $mesaj_per_masina . '. ';
                }
            }

            foreach ($soferi as $sofer) {
                $mesaj_per_sofer = '';
                if($sofer->fisa_medicala) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->fisa_medicala, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Fisa medicala ' . Carbon::parse($sofer->fisa_medicala)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->examen_psihologic) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->examen_psihologic, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Examen Psihologic ' . Carbon::parse($sofer->examen_psihologic)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->medicina_muncii) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->medicina_muncii, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Medicina muncii ' . Carbon::parse($sofer->medicina_muncii)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->permis) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->permis, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Permis ' . Carbon::parse($sofer->permis)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->atestat) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->atestat, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Atestat ' . Carbon::parse($sofer->atestat)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->card) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->card, false);
                    if(($zile_ramase < 5) || ($zile_ramase == 15)){
                        $mesaj_per_sofer .= 'Card ' . Carbon::parse($sofer->card)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }

                if ($mesaj_per_sofer) {
                    $mesaj_per_sofer = substr($mesaj_per_sofer, 0, -2); // stergerea ultimelor 2 caractere ", "
                    $mesaj_per_total .= 'Soferul ' . $sofer->nume . ': ' . $mesaj_per_sofer . '. ';
                }
            }

            if ($mesaj_per_total !== ''){
                // Trimitere alerta prin email
                // \Mail::
                //     to('rezervari@zuzulicatrans.ro')
                //     to('andrei.dima@usm.ro')
                //     ->bcc(['contact@validsoftware.ro', 'adima@validsoftware.ro'])
                //     ->send(new CronJobAlerteMasiniSoferi($mesaj_per_total)
                // );



                // Trimitere alerta prin SMS
                    echo 'Mesajul cu diacritice este: ' . $mesaj_per_total . '<br><br>';

                    // Referitor la diacritice, puteti face conversia unui string cu diacritice intr-unul fara diacritice, in mod automatizat cu aceasta functie PHP:
                    $transliterator = \Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);
                    // $textFaraDiacritice = $transliterator->transliterate($textCuDiacritice);
                    $mesaj_per_total = $transliterator->transliterate($mesaj_per_total);

                    // Trait continand functie cu argumentele: categorie(string), subcategorie(string), referinta_id(integer), telefoane(array), mesaj(string)
                    $this->trimiteSms('alerte masini soferi', null, null, ['0765518668'], $mesaj_per_total);

                    echo 'Mesajul fara diacritice este: ' . $mesaj_per_total;


            } else {
                echo 'Nu este nici un mesaj';
            }


            // return redirect('/clienti')->with('status', 'Cron Joburile de astăzi au fost trimise!' . $cron_jobs->count());
        } else {
            echo 'Cheia pentru Cron Joburi nu este corectă!';
            // return redirect('/clienti')->with('error', 'Cron Joburile de astăzi nu fost trimise! Cheia ' . $key . ' nu este validă');
        }

    }
}
