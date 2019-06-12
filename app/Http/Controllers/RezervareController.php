<?php

namespace App\Http\Controllers;

use App\Rezervare;
use App\Cursa;
use App\Oras;
use App\OrasStatie;
use App\TipPlata;
use App\CursaOra;
use DB;
use Illuminate\Http\Request;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI
        $search_telefon = \Request::get('search_telefon'); //<-- we use global request to get the param of URI
        $search_cod_bilet = \Request::get('search_cod_bilet'); //<-- we use global request to get the param of URI
        if (auth()->user()->firma->id == 1){
            $rezervari = Rezervare::join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                ->select('rezervari.*', 'curse_ore.ora')
                ->where('nume', 'like', '%' . $search_nume . '%')
                ->where('telefon', 'like', '%' . $search_telefon . '%')
                ->when($search_cod_bilet, function ($query, $search_cod_bilet) {
                    return $query->where( 'rezervari.id', $search_cod_bilet);
                })
                // ->where('rezervari.id', 'like', '%' . $search_cod_bilet . '%')
                ->latest('rezervari.created_at')
                ->paginate(100);
        }
        else {
            $rezervari = auth()->user()->rezervari()
                ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                ->select('rezervari.*', 'curse_ore.ora')
                ->where('nume', 'like', '%' . $search . '%')
                ->latest('rezervari.created_at')
                ->paginate(100);
        }
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
        return view('rezervari.index', compact('rezervari'));
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
        $rezervare_tur = Rezervare::make($this->validateRequest());
        $rezervare_retur = Rezervare::make($this->validateRequest());

        // stergerea oraselor din request, se foloseste id-ul cursei in DB
        // stergerea ore_plecare din request, se foloseste ora_id orei in DB
        // stergerea datelor de retur
        unset($rezervare_tur['oras_plecare'], $rezervare_tur['oras_sosire'], $rezervare_tur['ora_plecare'],
            $rezervare_tur['retur'], $rezervare_tur['retur_ora_id'], $rezervare_tur['retur_data_cursa'], $rezervare_tur['retur_zbor_oras_decolare'], $rezervare_tur['retur_zbor_ora_decolare'], $rezervare_tur['retur_zbor_ora_aterizare']);
        unset($rezervare_retur['oras_plecare'], $rezervare_retur['oras_sosire'], $rezervare_retur['ora_plecare'],
            $rezervare_retur['retur'], $rezervare_retur['retur_ora_id'], $rezervare_retur['retur_data_cursa'], $rezervare_retur['retur_zbor_oras_decolare'], $rezervare_retur['retur_zbor_ora_decolare'], $rezervare_retur['retur_zbor_ora_aterizare']);
        
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
        
        // dd($request, $rezervare_tur, $rezervare_retur);

        if ($request->retur == "false") {
            $rezervare_tur->save();
            return redirect($rezervare_tur->path())->with('status', 'Rezervarea pentru clientul "' . $rezervare_tur->nume . '" a fost adăugată cu succes!');
        } else {
            $rezervare_tur->save();
            $rezervare_retur->save();
            return redirect('/rezervari')->with('status', 'Rezervările tur si retur pentru clientul "' . $rezervare_tur->nume . '" au fost adăugate cu succes!');
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
        if (auth()->user()->isNot($rezervari->user) && (auth()->user()->firma->id != 1)) {
            abort(403);
        }
        return view('rezervari.show', compact('rezervari'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Rezervare $rezervari)
    {
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
        $this->validateRequest();
        $this->authorize('update', $rezervari);      
        
        // dd($rezervari, $request->ora_id);

        // aflarea id-ului cursei in functie de orasele introduse
        $cursa_id = Cursa::select('id')
            ->where([
                ['plecare_id', $request->oras_plecare],
                ['sosire_id', $request->oras_sosire]
            ])
            ->first();

        // setarea id-ului cursei in functie de orasele introduse
        $rezervari->cursa_id = $cursa_id->id;
        // $rezervari->ora_id = $request->ora_plecare;

        // $facturi->incasata = 0; // automat nu se trimite nici o valoare daca checkboxul este debifat
        // dd( $rezervari, $request->except('oras_plecare'), $this->validateRequest());
        // dd($request);
        $rezervari->update( $request->except(['oras_plecare', 'oras_sosire', 'ora_plecare', 'date']));

        return redirect($rezervari->path())->with('status', 'Rezervarea pentru clientul "' . $rezervari->nume . '" a fost modificată cu succes!');
    }

    public function update_activa(Request $request, Rezervare $rezervari)
    {
        $this->authorize('update', $rezervari);
        if ( $rezervari->activa == 0) {
            $rezervari->activa = 1;
        } else {
            $rezervari->activa = 0;
        }
        $rezervari->update();
        
        return redirect('/rezervari');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervari)
    {
        $this->authorize('update', $rezervari);
        $rezervari->delete();
        return redirect('/rezervari');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'cursa_id' =>['nullable', 'numeric', 'max:999'],
            'oras_plecare' => [ 'required', 'numeric', 'max:999'],
            'oras_sosire' => [ 'required', 'nullable', 'numeric', 'max:999'],
            'statie_id' => ['nullable', 'numeric', 'max:999'],
            'statie_imbarcare' => ['nullable'],
            'data_cursa' => [ 'required', 'max:50'],
            'ora_id' =>[ 'required', 'nullable', 'max:99'],
            'zbor_oras_decolare' => ['max:50'],
            'zbor_ora_decolare' => ['max:50'],
            'zbor_ora_aterizare' => ['max:50'],
            'nume' => ['required', 'max:100'],
            'telefon' => [ 'required', 'max:20'],
            'email' => ['max:50'],
            'nr_adulti' => [ 'nullable', 'numeric', 'max:99'],
            'nr_copii' => [ 'nullable', 'numeric', 'max:99'],
            'pret_total' => ['nullable', 'numeric', 'max:999999'],
            'observatii' => ['max:10000'],
            'comision_agentie' => [ 'nullable', 'numeric', 'max:999999'],
            // 'tip_plata_id' => [''],
            'retur' => [''],
            'retur_ora_id' =>[ 'required_if:retur,true', 'nullable', 'max:99'],
            'retur_data_cursa' => [ 'required_if:retur,true', 'max:50'],
            'retur_zbor_oras_decolare' => ['max:50'],
            'retur_zbor_ora_decolare' => ['max:50'],
            'retur_zbor_ora_aterizare' => ['max:50'],
            'order_id' => [''],
            'user_id' => [''],
            'status' => ['']
        ]);
    }

    public function pdfexport(Request $request, Rezervare $rezervari)
    {
        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervari'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
                    return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
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
        // if(empty($request->session()->get('rezervare'))){
            $request->session()->forget('rezervare');
            $rezervare = Rezervare::make($this->validateRequest());
            // $rezervare->fill($this->validateRequest());   

                // aflarea id-ului cursei in functie de orasele introduse
                $cursa_id = Cursa::select('id')
                    ->where([
                        ['plecare_id', $request->oras_plecare],
                        ['sosire_id', $request->oras_sosire]
                    ])
                    ->first();
                
                // setarea id-ului cursei in functie de orasele introduse
                $rezervare->cursa_id = $cursa_id->id;

                // stergerea oraselor din request, se foloseste id-ul cursei in DB
                // stergerea ore_plecare din request, se foloseste ora_id orei in DB
                unset($rezervare['oras_plecare'], $rezervare['oras_sosire'], $rezervare['ora_plecare'], $rezervare['cursa'], $rezervare['statie'], $rezervare['ora']);

            $request->session()->put('rezervare', $rezervare);
        // }else{
        //     $rezervare = $request->session()->get('rezervare');
        //     $rezervare->fill($this->validateRequest());

        //         // aflarea id-ului cursei in functie de orasele introduse
        //         $cursa_id = Cursa::select('id')
        //             ->where([
        //                 ['plecare_id', $request->oras_plecare],
        //                 ['sosire_id', $request->oras_sosire]
        //             ])
        //             ->first();
                
        //         // setarea id-ului cursei in functie de orasele introduse
        //         $rezervare->cursa_id = $cursa_id->id;

        //         // stergerea oraselor din request, se foloseste id-ul cursei in DB
        //         // stergerea ore_plecare din request, se foloseste ora_id orei in DB
        //         unset($rezervare['oras_plecare'], $rezervare['oras_sosire'], $rezervare['ora_plecare']);

        //     $request->session()->put('rezervare', $rezervare);
        // }

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
        $rezervare_array = $rezervare->toArray();
        unset($rezervare_array['cursa'], $rezervare_array['statie'], $rezervare_array['ora'], $rezervare_array['tip_plata'], $rezervare_array['id']);
        // dd($rezervare_array);
            $id = DB::table('rezervari')->insertGetId($rezervare_array);
        // $id = $rezervari->save->insertGetId;
        $rezervare->id = $id;

        // $rezervare->data_cursa = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervare->data_cursa)->format('d.m.Y');


        // dd($rezervare);
                
        $request->session()->put('rezervare', $rezervare);

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

        return redirect('/adauga-rezervare-pasul-3');

    }

        /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervare3(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');
        return view('rezervari.guest-create/adauga-rezervare3',compact('rezervare', $rezervare));
    }

    public function pdfexportguest(Request $request)
    {
        $rezervari = $request->session()->get('rezervare');
        // dd($rezervari);
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
            ->setPaper('a4');
                return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
    }
}
