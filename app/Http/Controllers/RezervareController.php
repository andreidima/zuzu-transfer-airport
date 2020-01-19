<?php

namespace App\Http\Controllers;

use App\Rezervare;
use App\Cursa;
use App\Oras;
use App\OrasStatie;
use App\TipPlata;
use App\CursaOra;
use App\ClientNeserios;
use App\SmsTrimis;
use DB;
use Illuminate\Http\Request;
use App\Mail\BiletClient;
use Illuminate\Validation\Rule;
use Session;

use Illuminate\Support\Facades\Auth;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $rezervare = Rezervare::latest()->first();
        // dd($rezervare->updated_at->isoFormat('HH'));
        // if (($rezervare->cursa->plecare_id !== 8) && 
        //     (($rezervare->updated_at->isoFormat('HH') > 22) ? 
        //         (
        //             // dd('aici')
        //             $rezervare->updated_at->isoFormat('D.MM.YYYY') == \Carbon\Carbon::now()->isoFormat('D.MM.YYYY')
        //             ||
        //             $rezervare->updated_at->isoFormat('D.MM.YYYY') == \Carbon\Carbon::tomorrow()->isoFormat('D.MM.YYYY')
        //         )
        //         : 
        //         $rezervare->updated_at->isoFormat('D.MM.YYYY') == \Carbon\Carbon::now()->isoFormat('D.MM.YYYY'))
        // ){
        //     dd('aici');
        // }


        $search_nume_telefon = \Request::get('search_nume_telefon'); //<-- we use global request to get the param of URI
        $search_cod_bilet = \Request::get('search_cod_bilet'); //<-- we use global request to get the param of URI
        // dd($search_cod_bilet);
        if (auth()->user()->id == 355){
            $rezervari = Rezervare::join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                ->select('rezervari.*', 'curse_ore.ora')
                ->when($search_nume_telefon, function ($query, $search_nume_telefon) {
                    return $query   ->where('nume', 'like', '%' . $search_nume_telefon . '%')
                                    ->orWhere('telefon', 'like', '%' . $search_nume_telefon . '%');
                })
                ->when($search_cod_bilet, function ($query, $search_cod_bilet) {
                    return $query->where( 'rezervari.id', $search_cod_bilet);
                })
                ->with('cursa.oras_plecare' ,'cursa.oras_sosire', 'tip_plata', 'statie', 'user.firma:id,nume')
                ->latest('rezervari.created_at')
                ->simplePaginate(100);
        }
        elseif (auth()->user()->isDispecer()){
            $rezervari = Rezervare::join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                ->select('rezervari.*', 'curse_ore.ora')
                ->when($search_nume_telefon, function ($query, $search_nume_telefon) {
                    return $query   ->where('nume', 'like', '%' . $search_nume_telefon . '%')
                                    ->orWhere('telefon', 'like', '%' . $search_nume_telefon . '%');
                })
                ->when($search_cod_bilet, function ($query, $search_cod_bilet) {
                    return $query->where( 'rezervari.id', $search_cod_bilet);
                })
                ->with('cursa.oras_plecare' ,'cursa.oras_sosire', 'tip_plata', 'statie', 'user.firma:id,nume')
                // ->where('nume', '<>', 'ANDREI DIMA TEST')
                ->latest('rezervari.created_at')
                ->simplePaginate(100);
        }
        else {
            $rezervari = auth()->user()->rezervari()
                ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                ->select('rezervari.*', 'curse_ore.ora')
                ->when($search_nume_telefon, function ($query, $search_nume_telefon) {
                    return $query   ->where('nume', 'like', '%' . $search_nume_telefon . '%')
                                    ->orWhere('telefon', 'like', '%' . $search_nume_telefon . '%');
                })
                ->when($search_cod_bilet, function ($query, $search_cod_bilet) {
                    return $query->where( 'rezervari.id', $search_cod_bilet);
                })
                ->with('user', 'cursa', 'tip_plata')
                ->latest('rezervari.created_at')
                ->simplePaginate(100);
        }

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        // $rezervaria = auth()->user()->rezervari()
        //     ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
        //     ->select('rezervari.*', 'curse_ore.ora')
        //     ->where('nume', 'like', '%' . $search . '%')
        //     ->latest('rezervari.created_at')
        //     ->paginate(100);
        // dd($rezervari, $rezervaria);
        // $rezervari_curente = auth()->user()->rezervari()
        //     ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
        //     ->select('rezervari.*', 'curse_ore.ora')
        //     ->where('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '=', \Carbon\Carbon::today())
        //     ->wherehas('ora', function ($query) {
        //         $query->where('ora', '>', \Carbon\Carbon::now());
        //     })
        //     ->orwhere('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '>', \Carbon\Carbon::today())
        //     ->orderBy('data_cursa')
        //     ->orderBy('ora')
        //     ->paginate(10);
        // $rezervari_curente_nr = auth()->user()->rezervari()
        //     ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
        //     ->select('rezervari.*', 'curse_ore.ora')
        //     ->where('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '=', \Carbon\Carbon::today())
        //     ->wherehas('ora', function ($query) {
        //         $query->where('ora', '>', \Carbon\Carbon::now());
        //     })
        //     ->orwhere('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '>', \Carbon\Carbon::today())
        //     ->count();
        // $rezervari_vechi = auth()->user()->rezervari()
        //     ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
        //     ->select('rezervari.*', 'curse_ore.ora')
        //     ->where('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '=', \Carbon\Carbon::today())
        //     ->wherehas('ora', function ($query) {
        //         $query->where('ora', '<', \Carbon\Carbon::now());
        //     })
        //     ->orwhere('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '<', \Carbon\Carbon::today())
        //     ->orderBy('data_cursa', 'desc')
        //     ->orderBy('ora', 'desc')
        //     ->paginate(10);
        // $rezervari_vechi_nr = auth()->user()->rezervari()
        //     ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
        //     ->select('rezervari.*', 'curse_ore.ora')
        //     ->where('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '=', \Carbon\Carbon::today())
        //     ->wherehas('ora', function ($query) {
        //         $query->where('ora', '<', \Carbon\Carbon::now());
        //     })
        //     ->orwhere('nume', 'like', '%' . $search . '%')
        //     ->where('data_cursa', '<', \Carbon\Carbon::today())
        //     ->count();

        // return view('rezervari.index', compact('rezervari_curente', 'rezervari_curente_nr', 'rezervari_vechi', 'rezervari_vechi_nr'));
        return view('rezervari.index', compact('rezervari', 'telefoane_clienti_neseriosi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $statii_imbarcare = OrasStatie::select('id', 'nume')
        //     ->where('oras_id', 4)
        //     ->get(); 
        // dd($statii_imbarcare);
        $curse = Cursa::select('id', 'plecare_id', 'sosire_id')
            ->get();
        $orase = Oras::has('curse_plecare')
            ->orderBy('nume')        
            ->get();
        $statii = OrasStatie::select('id', 'nume')
            ->orderBy('nume')
            ->get();
        $tipuri_plati = TipPlata::select('id', 'nume')
            ->orderBy('nume')
            ->get();

        return view('rezervari.create', compact('curse', 'orase', 'statii', 'tipuri_plati'));
    }

    /**
     * Returnarea oraselor de sosire
     */
    public function orase_ore_rezervari(Request $request)
    {
        $pret_adult = 0;
        $pret_copil = 0; 
        $statii_imbarcare = '';
        $raspuns = '';
        switch ($_GET['request']) {
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'nume')
                    ->where('id', '!=', '8')
                    ->wherehas('curse_plecare')
                    ->orderBy('nume')
                    ->get();
                break;
            case 'orase_sosire':        
                $oras_plecare = $request->oras_plecare;
                $raspuns = Oras::select('id', 'nume')
                    ->wherehas('curse_sosire', function ($query) use ($oras_plecare) {
                        $query->where('plecare_id', $oras_plecare);
                    })
                    ->orderBy('nume')
                    ->get();
                $statii_imbarcare = OrasStatie::select('id', 'nume')
                    ->where('oras_id', $oras_plecare)
                    ->get();          
                break;
            case 'ore_plecare': 
                $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
                    ->where([
                        ['plecare_id', $request->oras_plecare],
                        ['sosire_id', $request->oras_sosire]
                    ])
                    ->first();
                if(!empty($cursa)){
                    $raspuns = CursaOra::select('id', 'ora')
                        ->where('cursa_id', $cursa->id)
                        ->get();
                    foreach ($raspuns as $r){
                        $r->ora = \Carbon\Carbon::parse($r->ora)->format('H:i');
                    };
                    $pret_adult = $cursa->pret_adult;
                    $pret_copil = $cursa->pret_copil;
                }
                else{
                    $raspuns = '';
                }
                break;
            case 'ora_sosire':
                $cursa = Cursa::select('id', 'durata')
                    ->where([
                        ['plecare_id', $request->oras_plecare],
                        ['sosire_id', $request->oras_sosire],
                    ])
                    ->first();
                $cursa_ora = CursaOra::select('ora')
                    ->where('id', $request->ora_plecare)
                    ->first();
                if (!empty($cursa && $cursa_ora)) {
                    $raspuns = \Carbon\Carbon::parse($cursa_ora->ora)
                        ->addHours(\Carbon\Carbon::parse($cursa->durata)->hour)
                        ->addMinutes(\Carbon\Carbon::parse($cursa->durata)->minute)
                        ->format('H:i');
                } else {
                    $raspuns = '';
                }
                break;
            case 'retur_ore_plecare':
                $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
                    ->where([
                        ['plecare_id', $request->oras_sosire],
                        ['sosire_id', $request->oras_plecare]
                    ])
                    ->first();
                if(!empty($cursa)){
                    $raspuns = CursaOra::select('id', 'ora')
                        ->where('cursa_id', $cursa->id)
                        ->get();
                    foreach ($raspuns as $r){
                        $r->ora = \Carbon\Carbon::parse($r->ora)->format('H:i');
                    };
                }
                else{
                    $raspuns = '';
                }
                break;
            case 'retur_ora_sosire':
                $cursa = Cursa::select('id', 'durata')
                    ->where([
                        ['plecare_id', $request->oras_sosire],
                        ['sosire_id', $request->oras_plecare],
                    ])
                    ->first();
                $cursa_ora = CursaOra::select('ora')
                    ->where('id', $request->retur_ora_plecare)
                    ->first();
                if (!empty($cursa && $cursa_ora)) {
                    $raspuns = \Carbon\Carbon::parse($cursa_ora->ora)
                        ->addHours(\Carbon\Carbon::parse($cursa->durata)->hour)
                        ->addMinutes(\Carbon\Carbon::parse($cursa->durata)->minute)
                        ->format('H:i');
                } else {
                    $raspuns = '';
                }
                break;
            default:
                break;        
        }
        return response()->json([
            'raspuns' => $raspuns,
            'pret_adult' => $pret_adult,
            'pret_copil' => $pret_copil,
            'statii_imbarcare' => $statii_imbarcare
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rezervare_tur = Rezervare::make($this->validateRequest($request));
        $rezervare_retur = Rezervare::make($this->validateRequest($request));

        // stergerea oraselor din request, se foloseste id-ul cursei in DB
        // stergerea ore_plecare din request, se foloseste ora_id orei in DB
        // stergerea datelor de retur
        unset($rezervare_tur['oras_plecare'], $rezervare_tur['oras_sosire'], $rezervare_tur['ora_plecare'],
            $rezervare_tur['retur'], $rezervare_tur['retur_ora_id'], $rezervare_tur['retur_data_cursa'], $rezervare_tur['retur_zbor_oras_decolare'], $rezervare_tur['retur_zbor_ora_decolare'], $rezervare_tur['retur_zbor_ora_aterizare'],
            $rezervare_tur['plata_online'], $rezervare_tur['adresa']);
        unset($rezervare_retur['oras_plecare'], $rezervare_retur['oras_sosire'], $rezervare_retur['ora_plecare'],
            $rezervare_retur['retur'], $rezervare_retur['retur_ora_id'], $rezervare_retur['retur_data_cursa'], $rezervare_retur['retur_zbor_oras_decolare'], $rezervare_retur['retur_zbor_ora_decolare'], $rezervare_retur['retur_zbor_ora_aterizare'],
            $rezervare_retur['plata_online'], $rezervare_retur['adresa']);
        
        $rezervare_tur->user_id = auth()->user()->id;
        $rezervare_retur->user_id = auth()->user()->id;
        
        $this->authorize('update', $rezervare_tur);
        $this->authorize('update', $rezervare_retur);
        
        // $rezervare_tur->ora_id = $request->ora_id;

        $rezervare_retur->ora_id = $request->retur_ora_id;
        $rezervare_retur->data_cursa = $request->retur_data_cursa;
        $rezervare_retur->zbor_oras_decolare = $request->retur_zbor_oras_decolare;
        $rezervare_retur->zbor_ora_decolare = $request->retur_zbor_ora_decolare;
        $rezervare_retur->zbor_ora_aterizare = $request->retur_zbor_ora_aterizare;
        $rezervare_retur->statie_imbarcare = $request->retur_statie_imbarcare;

        $rezervare_tur->nume = strtoupper($rezervare_tur->nume);
        $rezervare_retur->nume = strtoupper($rezervare_retur->nume);

        $rezervare_tur->zbor_oras_decolare = strtoupper($rezervare_tur->zbor_oras_decolare);
        $rezervare_retur->zbor_oras_decolare = strtoupper($rezervare_retur->zbor_oras_decolare);

        // aflarea id-ului cursei in functie de orasele introduse
        $cursa_id_tur = Cursa::select('id')
            ->where([
                ['plecare_id', $request->oras_plecare],
                ['sosire_id', $request->oras_sosire]
            ])
            ->first();
        $cursa_id_retur = Cursa::select('id')
            ->where([
                ['plecare_id', $request->oras_sosire],
                ['sosire_id', $request->oras_plecare]
            ])
            ->first();

        // setarea id-ului cursei in functie de orasele introduse
        $rezervare_tur->cursa_id = $cursa_id_tur->id;
        $rezervare_retur->cursa_id = $cursa_id_retur->id;
        
        // Calcularea pretului total
        $pret_total = 0;
        $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
                    ->where('id', $cursa_id_tur->id)
                    ->first();
        if(!empty($cursa)){
            if(is_numeric($request->nr_adulti) && ($request->nr_adulti > 0)){
                $pret_total += $request->nr_adulti * $cursa->pret_adult;
            }
            if(is_numeric($request->nr_copii) && ($request->nr_copii > 0)){
                $pret_total += $request->nr_copii * $cursa->pret_copil;
            }
        }
        $rezervare_tur->pret_total = $pret_total;
        $rezervare_retur->pret_total = $pret_total;

        // daca se bifeaza plata la agentie, automat comision = pret_tatal
        // daca se introduce comision, automat se bifeaza plata la agentie        
        if (is_numeric($request->comision_agentie) && ($request->comision_agentie > 0)) {
            $rezervare_tur->tip_plata_id = 2;
            $rezervare_retur->tip_plata_id = 2;
        }
        else if(empty($request->tip_plata_id)){
            $rezervare_tur->tip_plata_id = 1;
            $rezervare_retur->tip_plata_id = 1;            
        }        

        // Trimitere email pentru rezervare tur si retur daca este cazul
        if (!empty($rezervare_tur->email)) {
            \Mail::to($rezervare_tur->email)->send(
                new BiletClient($rezervare_tur, ($request->retur == "true" ? $rezervare_retur : null ))
            );
        }   

        if ($request->retur == "false") {
            $rezervare_tur->save();

            //Trimitere sms
            $this->trimiteSms($rezervare_tur);

            return redirect($rezervare_tur->path())->with('status', 'Rezervarea pentru clientul "' . $rezervare_tur->nume . '" a fost adăugată cu succes!');
        } else {
            $rezervare_tur->save();
            $rezervare_retur->save();

            //Trimitere sms
            $this->trimiteSms($rezervare_tur);
            $this->trimiteSms($rezervare_retur);

            $rezervare_tur->tur_retur = $rezervare_retur->id;
            $rezervare_tur->update();
            
            $rezervare_retur->tur_retur = $rezervare_tur->id;
            $rezervare_retur->update();

            //Modificare preturi pentru oferta de minim 5 adulti, Braila sau Galati, tur retur, plata la agentie
            // dd($rezervare_tur->oferta, $rezervare_retur->oferta, $rezervare_tur->nr_adulti, $rezervare_tur->tip_plata_id,
            //     $rezervare_tur->retur,
            //     $rezervare_tur->cursa->oras_plecare->nume,
            //     $rezervare_retur->id);
            // dd($request);
            if (($request->action == "cu_oferta") &&
                ($rezervare_tur->oferta == null) && ($rezervare_retur->oferta == null) &&
                ($rezervare_tur->nr_adulti > 4) && ($rezervare_tur->tip_plata_id = 2) && 
                ($rezervare_tur->tur_retur == $rezervare_retur->id) && 
                (($rezervare_tur->cursa->oras_plecare->id == 2) || ($rezervare_tur->cursa->oras_plecare->id == 5) || ($rezervare_tur->cursa->oras_plecare->id == 6))
                ){
                    $rezervare_tur->oferta = 1;
                    $rezervare_tur->pret_total = ($rezervare_tur->nr_adulti * 100) + ($rezervare_tur->nr_copii * 60);
                    $rezervare_tur->update();

                    $rezervare_retur->oferta = 1;
                    $rezervare_retur->pret_total = 0;
                    $rezervare_retur->update();
            }

            return redirect('/rezervari/tur_retur/'.$rezervare_tur->id.'/'.$rezervare_retur->id)->with('status', 'Rezervările tur si retur pentru clientul "' . $rezervare_tur->nume . '" au fost adăugate cu succes!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function show(Rezervare $rezervari)
    {
        $this->authorize('update', $rezervari);

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        return view('rezervari.show', compact('rezervari', 'telefoane_clienti_neseriosi'));
    }

    public function show_dupa_modificare(Rezervare $rezervari)
    {
        $this->authorize('update', $rezervari);

        return view('rezervari.show_dupa_modificare', compact('rezervari'));
    }
    public function show_rezervare_tur_retur(Rezervare $rezervare_tur, Rezervare $rezervare_retur)
    {
        $this->authorize('update', $rezervare_tur);        
        $this->authorize('update', $rezervare_retur);

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        return view('rezervari.show_rezervare_tur_retur', compact('rezervare_tur', 'rezervare_retur', 'telefoane_clienti_neseriosi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Rezervare $rezervari)
    {
        $this->authorize('update', $rezervari);
        return view('rezervari.edit', compact('rezervari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rezervare $rezervari)
    {
        if (auth()->user()->isDispecer()){ 
            $this->validateRequest($request, $rezervari);
            $this->authorize('update', $rezervari);    

            // aflarea id-ului cursei in functie de orasele introduse
            $cursa_id = Cursa::select('id')
                ->where([
                    ['plecare_id', $request->oras_plecare],
                    ['sosire_id', $request->oras_sosire]
                ])
                ->first();

            // setarea id-ului cursei in functie de orasele introduse
            $rezervari->cursa_id = $cursa_id->id;

            $rezervari->update( $request->except(['oras_plecare', 'oras_sosire', 'ora_plecare', 'date', 'retur', 'retur_ora_id',
                'retur_data_cursa', 'retur_zbor_oras_decolare', 'retur_zbor_ora_decolare', 'retur_zbor_ora_aterizare',
                'plata_online', 'adresa']));

            $rezervari->nume = strtoupper($rezervari->nume);
            $rezervari->zbor_oras_decolare = strtoupper($rezervari->zbor_oras_decolare);
            $rezervari->update();
        }
        else{
            $validatedData = $request->validate([
                'telefon' => auth()->user()->isDispecer() ? [ 'required', 'max:100'] : [ 'required ', 'regex:/^[0-9 ]+$/', 'max: 100'],
                'statie_imbarcare' => 'nullable',
            ],
            [
                'telefon.regex' => 'Câmpul telefon poate conține doar cifre și spații'
            ]
            );

            $this->authorize('update', $rezervari);
            
            $rezervari->update( $request->only(['telefon', 'statie_imbarcare']));
        }

        //Trimitere sms
        $this->trimiteSms($rezervari);

        // dd(Config::get('mail'));

        // Trimitere email
        // if (!empty($rezervari->email)) {
        //     \Mail::to($rezervari->email)->send(
        //         new BiletClient($rezervari)
        //     );
        // }

        return redirect($rezervari->path().'/rezervare_modificata')->with('status', 'Rezervarea pentru clientul "' . $rezervari->nume . '" a fost modificată cu succes!');
    }

    public function update_activa(Request $request, Rezervare $rezervari)
    {
        if (auth()->user()->isDispecer()){
            $this->authorize('update', $rezervari);
            if ( $rezervari->activa == 0) {
                $rezervari->activa = 1;
                //Trimitere sms
                $this->trimiteSms($rezervari, ' Rezervarea a fost activata');
            } else {
                $rezervari->activa = 0;
                //Trimitere sms
                $this->trimiteSms($rezervari, ' Rezervarea a fost anulata');
            }
            $rezervari->update();
            
            return redirect('/rezervari');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervari)
    {
        $this->authorize('delete', $rezervari);
        $rezervari->delete();

        //Trimitere sms
        // $this->trimiteSms($rezervari, ' Rezervarea a fost stearsa');

        return redirect('/rezervari');
    }

    public function massSelect(Request $request)
    {
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $deleted_rows_number = 0;
        $delete_rows_mesaj = '';

        if(isset($search_data_sfarsit)) {
            $deleted_rows_number = Rezervare::where('data_cursa', '<', $search_data_sfarsit)->count();            
        }

        return view('rezervari.mass-delete', compact('search_data_sfarsit', 'deleted_rows_number', 'delete_rows_mesaj'));
    }
    public function massDelete(Request $request, $search_data_sfarsit, $deleted_rows_number)
    {
        // dd($request, $search_data_sfarsit, $deleted_rows_number);
        $delete_rows_mesaj = '';

        if (isset($search_data_sfarsit) && isset($deleted_rows_number)) {
            $delete_rows = Rezervare::where('data_cursa', '<', $search_data_sfarsit)->delete();
            // $this->authorize('delete', $delete_rows);
            // dd($delete_rows);
            // $delete_rows->delete();

            $delete_rows_mesaj = 'Toate rezervarile pana la data de ' . $search_data_sfarsit . ', ' . $deleted_rows_number . ' rezervari, au fost sterse cu succes!';

            $search_data_sfarsit = null;
            $deleted_rows_number = 0;
        }
        return view('rezervari.mass-delete', compact('search_data_sfarsit', 'deleted_rows_number', 'delete_rows_mesaj'));
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $rezervari = null)
    {
        // dd ($request->_method);
        return request()->validate([
            'cursa_id' =>['nullable', 'numeric', 'max:999'],
            'oras_plecare' => [ 'required', 'numeric', 'max:999'],
            'oras_sosire' => [ 'required', 'nullable', 'numeric', 'max:999'],
            'statie_id' => ['nullable', 'numeric', 'max:999'],
            'statie_imbarcare' => ['nullable'],
            'data_cursa' => [ 'required', 'max:50'],
            'ora_id' =>[ 'required', 'nullable', 'max:99'],
            // 'ora_plecare' => [''] // pastrata pentru old(ora_plecare) in formular
            'zbor_oras_decolare' => ['max:18'],
            'zbor_ora_decolare' => ['max:15'],
            'zbor_ora_aterizare' => ['max:15'],
            // 'nume' => ($request->_method === "PATCH") ?
            //     ['required', 'max:200', 'unique:rezervari,nume,' . $rezervari->id . ',id,telefon,' . $request->telefon . ',data_cursa,' . $request->data_cursa . ',ora_id,' . $request->ora_id]
            //     :
            //     ['required', 'max:200', 'unique:rezervari,nume,NULL,id,telefon,' . $request->telefon . ',data_cursa,' . $request->data_cursa . ',ora_id,' . $request->ora_id],
            'nume' => ($request->_method === "PATCH") ?
                ['required', 'max:200',
                    Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use($rezervari,$request) {
                        return $query->where('telefon', $request->telefon)
                                    ->where('data_cursa', $request->data_cursa)
                                    ->where('ora_id', $request->ora_id);
                    }),        
                ]
                :
                ['required', 'max:200',
                    Rule::unique('rezervari')->where(function ($query) use($rezervari,$request) {
                        return $query->where('telefon', $request->telefon)
                                    ->where('data_cursa', $request->data_cursa)
                                    ->where('ora_id', $request->ora_id);
                    }),        
                ],
            'telefon' => (auth()->user() === null) ? [ 'required', 'regex:/^[0-9 ]+$/', 'max: 100'] : (auth()->user()->isDispecer() ? [ 'required', 'max:100'] : [ 'required ', 'regex:/^[0-9 ]+$/', 'max: 100']),
            // 'telefon' => [''],
            'email' => auth()->user() === null ? [ 'required', 'email', 'max:100'] : ['nullable', 'email', 'max:100'],
            // 'nr_adulti' => [ 'required', 'integer', 'between:1,20'],
            // 'nr_copii' => [ 'nullable', 'integer', 'between:0,10'],
            'nr_adulti' => (auth()->user() === null) ? [ 'required', 'integer', 'between:1,20'] : (auth()->user()->isDispecer() ? [ 'required', 'integer', 'between:1,100'] : [ 'required', 'integer', 'between:1,20']),
            'nr_copii' => (auth()->user() === null) ? [ 'nullable', 'integer', 'between:0,10'] : (auth()->user()->isDispecer() ? [ 'nullable', 'integer', 'between:0,100'] : [ 'nullable', 'integer', 'between:0,10']),
            'pret_total' => ['nullable', 'numeric', 'max:999999'],
            'observatii' => ['max:10000'],
            'comision_agentie' => [ 'nullable', 'numeric', 'max:999999'],
            'tip_plata_id' => [''],
            'retur' => [''],
            'retur_ora_id' =>[ 'required_if:retur,true', 'nullable', 'max:99'],
            'retur_data_cursa' => [ 'required_if:retur,true', 'max:50'],
            'retur_zbor_oras_decolare' => ['max:100'],
            'retur_zbor_ora_decolare' => ['max:100'],
            'retur_zbor_ora_aterizare' => ['max:100'],
            
            'plata_online' => [''],
            // 'adresa' => ['required_if:plata_online,true', 'nullable', 'max:99'],

            'order_id' => [''],
            'user_id' => [''],
            'status' => [''],
            'plata_cu_card' => [''],
            'acord_de_confidentialitate' => auth()->user() === null ? ['required'] : [''],
            // 'oferta' => [''],
        ],
        [
            'ora_id.required' => 'Câmpul Ora de plecare este obligatoriu.',
            'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
            'nume.unique' => 'Această Rezervare este deja înregistrată.',
            // 'adresa.required_if' => 'Câmpul Adresa este obligatoriu dacă este selectată plata cu card'
        ]
        );
    }

    public function pdfexport(Request $request, Rezervare $rezervari)
    {
        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervari'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
                    // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                    return $pdf->download('Rezervare ' . $rezervari->nume . '.pdf');
        }
        // elseif($request->view_type === 'fisa-de-date-a-imobilului-pdf'){
        //     $pdf = PDF::loadView('registru.export.pdf-fisa-de-date-a-imobilului', ['registre' => $registre]) ->setPaper('a4');
        //     return $pdf->download($registru->id.'.pdf');
        // }
        // else{
        // } 
    }


    //
    // Functii pentru Multi Page Form pentru Clienti
    //
        /**
     * Show the step 1 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervare1(Request $request)
    {
        $curse = Cursa::select('id', 'plecare_id', 'sosire_id')
            ->get();
        $orase = Oras::has('curse_plecare')
            ->orderBy('nume')        
            ->get();
        $statii = OrasStatie::select('id', 'nume')
            ->orderBy('nume')
            ->get();
        $tipuri_plati = TipPlata::select('id', 'nume')
            ->orderBy('nume')
            ->get();

        $rezervare = $request->session()->get('rezervare');
        return view('rezervari.guest-create/adauga-rezervare1',compact('rezervare', $rezervare, 'curse', 'orase', 'statii', 'tipuri_plati'));


    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervare1(Request $request)
    {       
            $request->session()->forget('rezervare');
            $rezervare = Rezervare::make($this->validateRequest($request)); 

                // aflarea id-ului cursei in functie de orasele introduse
                $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
                    ->where([
                        ['plecare_id', $request->oras_plecare],
                        ['sosire_id', $request->oras_sosire]
                    ])
                    ->first();
                
                // setarea id-ului cursei in functie de orasele introduse
                $rezervare->cursa_id = $cursa->id;

                // calcularea pretului total
                $rezervare->pret_total = $cursa->pret_adult * $rezervare->nr_adulti + $cursa->pret_copil * $rezervare->nr_copii;

                $rezervare->nume = strtoupper($rezervare->nume);
                $rezervare->zbor_oras_decolare = strtoupper($rezervare->zbor_oras_decolare);


                // stergerea oraselor din request, se foloseste id-ul cursei in DB
                // stergerea ore_plecare din request, se foloseste ora_id orei in DB
                unset($rezervare['oras_plecare'], $rezervare['oras_sosire'], $rezervare['ora_plecare'], $rezervare['cursa'], $rezervare['statie'], $rezervare['ora'],
                    $rezervare['acord_de_confidentialitate']);

            $request->session()->put('rezervare', $rezervare);

        return redirect('/adauga-rezervare-pasul-2');
    }

        /**
     * Show the step 2 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervare2(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');
        return view('rezervari.guest-create/adauga-rezervare2',compact('rezervare', $rezervare));
    }

    /**
     * Post Request to store step2 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervare2(Request $request)
    {       
        // if(empty($request->session()->get('rezervare'))){
        //     $rezervare = new Rezervare();
        //     $rezervare->fill($this->validateRequest());
        //     $request->session()->put('rezervare', $rezervare);
        // }else{
        //     $rezervare = $request->session()->get('rezervare');
        //     $rezervare->fill($this->validateRequest());
        //     $request->session()->put('rezervare', $rezervare);
        // }

        $rezervare = $request->session()->get('rezervare');
        $rezervare->created_at = \Carbon\Carbon::now();
        $rezervare->updated_at = \Carbon\Carbon::now();
        $rezervare->tip_plata_id = 1;


        // aflarea id-ului cursei in functie de orasele introduse
        $cursa = Cursa::select('id', 'pret_adult', 'pret_copil')
            ->where('id', $rezervare->cursa_id)
            ->first();

        // calcularea pretului total
        $rezervare->pret_total = $cursa->pret_adult * $rezervare->nr_adulti + $cursa->pret_copil * $rezervare->nr_copii;


        $rezervare_array = $rezervare->toArray();
        $plata_online = $rezervare_array['plata_online'];
        unset($rezervare_array['cursa'], $rezervare_array['statie'], $rezervare_array['ora'], $rezervare_array['tip_plata'], $rezervare_array['id'],
            $rezervare_array['plata_online'], $rezervare_array['adresa']);
            
        
        // Verificare rezervare duplicat
        $request_verificare_duplicate = new Request([
            'nume' => $request->session()->get('rezervare.nume'),
            'telefon' => $request->session()->get('rezervare.telefon'),
            'data_cursa' => $request->session()->get('rezervare.data_cursa'),
            'ora_id' => $request->session()->get('rezervare.ora_id')
        ]);

        $this->validate($request_verificare_duplicate, [
            'nume' => ['required', 'max:100', 'unique:rezervari,nume,NULL,id,telefon,' . $request_verificare_duplicate->telefon . ',data_cursa,' . $request_verificare_duplicate->data_cursa . ',ora_id,' . $request_verificare_duplicate->ora_id]
        ],
        [
            'nume.unique' => 'Această Rezervare este deja înregistrată.'
        ]);

        
        //Inserarea rezervarii in baza de date
        $id = DB::table('rezervari')->insertGetId($rezervare_array);
        
        // $id = $rezervari->save->insertGetId;
        
        $rezervare->id = $id;

        // $rezervare->data_cursa = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y');

        $request->session()->put('rezervare', $rezervare);

        // dd($plata_online);

        // if($rezervari->save()){
        //     dd(Response::json(array('success' => true, 'last_insert_id' => $rezervari->id), 200));
        // };
        // dd($request);
        // $rezervare = $request->session()->get('rezervare');
        // if (!empty($rezervare->data_cursa)){
        //     $rezervare->data_cursa = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y');
        // }
        // $request->session()->put('rezervare', $rezervare);
        // dd($request->session()->get('rezervare'));        

        // Trimitere email
        if (!empty($rezervare->email)) {
            \Mail::to($rezervare->email)->send(
                new BiletClient($rezervare)
            );
        }

        //Trimitere sms
        $this->trimiteSms($rezervare);

        if ($plata_online == 1){
            return redirect('/trimitere-catre-plata');
        }else{
        return redirect('/adauga-rezervare-pasul-3');
        }
    }

        /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervare3(Request $request)
    {
        // if ((Auth::check()) && (Auth::user()->id == 355)) {
        //     dd($request->session()->get('rezervare'), $request->orderId);
        // }

        // if (Session::has('rezervare')) {
        //     $rezervare = $request->session()->get('rezervare');
        // }else {
        //     $payment = DB::table('payment_notifications')->where('order_id', $request->orderId)->first();
        //     $rezervare = DB::table('rezervari')->where('id', $payment->rezervare_id)->first();
        // }

        if ($request->has('orderId')) {
            $plata_online = \App\PlataOnline::where('order_id', $request->orderId)->latest()->first();
            $rezervare = \App\Rezervare::where('id', $plata_online->rezervare_id)->first();

            $request->session()->put('plata_online', $plata_online);
            $request->session()->forget('rezervare');
            $request->session()->put('rezervare_id', $rezervare->id);

            // dd($rezervare, $rezervare->ora->ora);

            return view('rezervari.guest-create/adauga-rezervare3', compact('rezervare', 'plata_online'));

        } else {
            $rezervare = $request->session()->get('rezervare');
            
            return view('rezervari.guest-create/adauga-rezervare3', compact('rezervare'));
        }

        // $request->session()->forget('rezervare');
        // $request->session()->flush();
        // dd (session()); 
    }

    public function pdfexportguest(Request $request)
    {
        if (Session::has('plata_online')) {
            $rezervari = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
            // dd($rezervari);
        }else {
            $rezervari = $request->session()->get('rezervare');
        }

        // dd($rezervari);
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
            ->setPaper('a4');
                return $pdf->download('Rezervare ' . $rezervari->nume . '.pdf');
    }


    public function trimiteSms(Rezervare $rezervare, $mesaj_aditional = null)
    {
        if (($rezervare->cursa->plecare_id !== 8) &&
            (($rezervare->updated_at->isoFormat('HH') > 21) ?
                (
                    \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D.MM.YYYY') == \Carbon\Carbon::now()->isoFormat('D.MM.YYYY')
                    ||
                    \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D.MM.YYYY') == \Carbon\Carbon::tomorrow()->isoFormat('D.MM.YYYY')
                )
                : 
                \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D.MM.YYYY') == \Carbon\Carbon::now()->isoFormat('D.MM.YYYY')
            )
        ){

            // $rezervare->created_at = \Carbon\Carbon::now();
            $telefoane = ['0752926589', '0767931404', '0762646917'];
            // $telefoane = ['0765296796'];
            $mesaj = (\Carbon\Carbon::parse($rezervare->ora->ora)->format('H:i') ?? '') . '. ' .
                ($rezervare->cursa->oras_plecare->nume ?? '') . ' (' .
                ($rezervare->statie->nume ?? $rezervare->statie_imbarcare) . ') ' .
                $rezervare->nume . ' ' .
                $rezervare->telefon . '. ' .
                $rezervare->nr_adulti . ' adulti ' .
                (($rezervare->nr_copii > 0) ? ('+ ' . $rezervare->nr_copii . ' copii') : '') . 
                ' = ' . $rezervare->pret_total . ' lei. ' .
                \Carbon\Carbon::parse($rezervare->data_cursa)->isoFormat('D.MM.YY') . ' ' .
                $mesaj_aditional;

            foreach ($telefoane as $telefon) {

                // ----------------------------------------------------------------------------
                // 
                //    Exemplu minimal pentru trimiterea de SMS-uri (PHP)
                //    Serviciul SMS Gateway
                //    Versiunea 1.1 / 12.04.2010
                //    Distribuit gratuit    
                //
                // ----------------------------------------------------------------------------

                // ----------------------------------------------------------------------------
                //  Pasul 1    
                //  Interogam SMS Gateway si salvam rezultatul trimis de acesta in variabila 
                //  pentru a putea interpreta statutul trimiterii
                //   - Pentru HTTPS utilizati https://secure.smslink.ro
                // ----------------------------------------------------------------------------
                // $mesaj = "Salutare domnule";
                $content = file_get_contents("http://www.smslink.ro/sms/gateway/communicate/?" .
                    "connection_id=" . $_ENV['SMSLINK_CONNECTION_ID'] . "&password=" . $_ENV['SMSLINK_PASSWORD'] .
                    "&to=" . $telefon . "&message=" .
                    // urlencode("Salut " . $rezervari->nume) .
                    urlencode($mesaj) .
                    '&test=1');
                // dd($content);
                // ----------------------------------------------------------------------------
                //  Pasul 2
                //  Interpretam rezultatul pentru a avea acces la tot continutul acestuia si
                //  a putea intelege rezultatul mesajului trimis spre SMS Gateway
                //
                //  Rezultatul transmis de SMS Gateway va fi intotdeauna de forma urmatoare:
                //  string Nivel;int ID Rezultat;string Mesaj;string[optional] Variabile
                // ----------------------------------------------------------------------------
                //  Pasul 2.1
                //  Extragem din rezultat toate variabilele separate prin punct si virgula 
                // ----------------------------------------------------------------------------
                list($level, $id, $response, $variabiles) = explode(";", $content . ';');

                // ----------------------------------------------------------------------------
                //  Pasul 2.2
                //  Verificam daca mesajul trimis a fost transmis cu succes prin compararea
                //  Nivelului si ID Rezultat
                // ----------------------------------------------------------------------------
                //  Daca mesajul este transmis atunci Nivelul va fi MESSAGE si ID- rezultat 
                //  va avea valoarea numerica 1    
                // ----------------------------------------------------------------------------
                if (($level == "MESSAGE") and ($id == 1)) {
                    // ------------------------------------------------------------------------    
                    //  Variabilele optionale transmise optional sunt separate prin virgula
                    //  si vor avea forma urmatoare:
                    //  mixed Variabila 1,mixed Variabila 2 ... mixed Variabila 3                
                    // ------------------------------------------------------------------------
                    $variabiles = explode(",", $variabiles);

                    // ------------------------------------------------------------------------
                    //  Extragem ID-ul Mesajului alocat de gateway pentru a il salva pentru
                    //  utilizare ulterioara. Message ID  va fi intotdeauna prima variabila 
                    //  trimisa, restul fiind explicate complet in documentatia de pe site. 
                    // ------------------------------------------------------------------------
                    $message_id = $variabiles[0];

                    // ------------------------------------------------------------------------
                    //  Pasul 3
                    //  Afisam mesajul de confirmare si afisam Message ID-ul alocat
                    // ------------------------------------------------------------------------
                    // echo "Mesajul a fost trimis si are ID-ul " . $message_id . "!";

                    $smsTrimis = new SmsTrimis;
                    $smsTrimis->rezervare_id = $rezervare->id;
                    $smsTrimis->telefon = $telefon;
                    $smsTrimis->mesaj = $mesaj;
                    $smsTrimis->trimis = 1;
                    $smsTrimis->mesaj_id = $message_id;
                    $smsTrimis->raspuns = $response;
                    $smsTrimis->content = $content;
                    $smsTrimis->save();
                    // return redirect('/clienti')->with('status', 'SMS-ul către "' . $clienti->nume . '" a fost trimis cu succes și are ID-ul ' . $message_id . "!");
                    // return redirect('/clienti')->with('status', 'SMS-ul către "' . $clienti->nume . '" a fost trimis cu succes!');
                    // $raspuns['sms-trimis'] = $smsTrimis;
                    // return ($raspuns);
                } else {
                    if ($level == "ERROR") {
                        // --------------------------------------------------------------------
                        //  Pasul 3
                        //  Afisam mesajul de eroare si afisam ID-ul erorii si descrierea
                        // --------------------------------------------------------------------
                        // echo "A intervenit eroarea ID " . $id . ", Descriere " . $response;

                        $smsTrimis = new SmsTrimis;
                        $smsTrimis->rezervare_id = $rezervare->id;
                        $smsTrimis->telefon = $telefon;
                        $smsTrimis->mesaj = $mesaj;
                        $smsTrimis->trimis = 0;
                        $smsTrimis->raspuns = $response;
                        $smsTrimis->content = $content;
                        $smsTrimis->save();

                        // return redirect('/clienti')->with('status', "A intervenit eroarea ID " . $id . ", Descriere: " . $response);
                        // $raspuns = array();
                        // array_push($raspuns, $smsTrimis);
                        // array_push($raspuns, $response);
                        // $raspuns = [];
                        // $raspuns['sms-trimis'] = $smsTrimis;
                        // $raspuns['id'] = $id;
                        // $raspuns['raspuns'] = $response;
                        // return ($raspuns);
                    }
                }
            }
        }
    }
}