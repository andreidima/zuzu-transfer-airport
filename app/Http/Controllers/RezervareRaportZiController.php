<?php

namespace App\Http\Controllers;

use App\Rezervare;
use Illuminate\Http\Request;
use App\Oras;
use App\Cursa;
use App\CursaOra;

class RezervareRaportZiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI
        $search_oras = \Request::get('search_oras'); //<-- we use global request to get the param of URI
        $search_ora = \Request::get('search_ora'); //<-- we use global request to get the param of URI
        
        $orase = Oras::has('curse_plecare')
            ->orderBy('nume')        
            ->get();
        
        if(isset($search_data_inceput) && !isset($search_data_sfarsit)) {
            $search_data_sfarsit = $search_data_inceput;
        }

        if(isset($search_data_inceput) && isset($search_data_sfarsit)) {
            if (auth()->user()->firma->id == 1) {
                $rezervari = Rezervare::
                    with(
                        'cursa.oras_plecare', 
                        'cursa.oras_sosire', 
                        'statie', 
                        // 'ora', 
                        'tip_plata', 
                        'user.firma'
                    )
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where( 'data_cursa', '<=', $search_data_sfarsit)
                    ->whereHas('cursa', function ($query) use ($search_oras){
                        if (!empty($search_oras)){
                            $query->where('plecare_id', '=', $search_oras);
                        }
                    })
                    ->where(function ($query) use ($search_ora){
                        if (!empty($search_ora)){
                            $query->where('ora_id', '=', $search_ora);
                        }
                    })
                    ->latest('rezervari.created_at')
                    ->simplePaginate(100);
            } else {
                $rezervari = auth()->user()->rezervari()
                    ->with('cursa', 'statie', 'tip_plata', 'user')
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where('data_cursa', '<=', $search_data_sfarsit)
                    ->latest('rezervari.created_at')
                    ->simplePaginate(100);
            }
        }
        else {
            // $rezervari = collect(new Rezervare)->simplePaginate(100);
            $rezervari = Rezervare::where('nume', 'xxxxxxxxxxxxxxxxx')->simplePaginate(100);
        }


        $search_data_inceput = '2020/08/01';
        $search_data_sfarsit = '2020/08/01';
        $search = '2020/08/01';
        $search_ieri = \Carbon\Carbon::parse($search)->subDay()->format('Y-m-d');

        $rezervari_test = Rezervare::where('data_cursa', '>=', '2020.08.01')
            ->where('data_cursa', '<=', '2020.08.01')
            ->get();


        $trasee_nume_tecuci_otopeni = \App\TraseuNume::select('id', 'nume')
            ->where('id', 1)
            ->with(
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa'
            )
            ->with(
                ['trasee.rezervari' => function ($query) use ($search, $search_ieri) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where(function ($query) use ($search_ieri) {
                            $query->whereIn('ora_id', [293, 294, 307])
                                ->where('data_cursa', $search_ieri)
                                ->where('activa', 1);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->whereNotIn('ora_id', [293, 294, 307])
                                ->where('data_cursa', $search)
                                ->where('activa', 1);
                        });
                }]
            )
            ->with(
                ['trasee.curse_ore.rezervari' => function ($query) use ($search, $search_ieri) {
                    $query->where(function ($query) use ($search_ieri) {
                        $query
                            ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                            ->whereIn('ora_id', [293, 294, 307])
                            ->where('data_cursa', $search_ieri)
                            ->where('activa', 1);
                    })
                        ->orWhere(function ($query) use ($search) {
                            $query->whereNotIn('ora_id', [293, 294, 307])
                                ->where('data_cursa', $search)
                                ->where('activa', 1);
                        });
                }]
            )
            ->get();
        $trasee_nume_galati_otopeni = \App\TraseuNume::select('id', 'nume')
            ->where('id', 2)
            ->with(
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where('data_cursa', $search)
                        ->where('activa', 1);
                }]
            )
            ->with(
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa'
            )
            ->with(
                ['trasee.curse_ore.rezervari' => function ($query) use ($search) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where('data_cursa', $search)
                        ->where('activa', 1);
                }]
            )
            ->get();
        $trasee_nume_otopeni = \App\TraseuNume::select('id', 'nume')
            ->where('id', 3)
            ->with(
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where('data_cursa', $search)
                        ->where('activa', 1);
                }]
            )
            ->with(
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa'
            )
            ->with(
                ['trasee.curse_ore.rezervari' => function ($query) use ($search) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where('data_cursa', $search)
                        ->where('activa', 1);
                }]
            )
            ->get();



        // dd ($search_oras, $rezervari);
        return view('rezervari-raport-zi.index', compact('rezervari', 'search_data_inceput', 'search_data_sfarsit', 'orase', 'search_oras', 'search_ora'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function show(Rezervare $rezervare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Rezervare $rezervare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rezervare $rezervare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervare)
    {
        //
    }

    

    /**
     * Returnarea oraselor de sosire
     */
    public function orase_ore_zi_rezervari(Request $request)
    { 
        $raspuns = '';
        switch ($_GET['request']) {
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'nume')
                    ->wherehas('curse_plecare')
                    ->orderBy('nume')
                    ->get();
                break;
            case 'ore':
                $search_oras = $request->search_oras;
                $raspuns = CursaOra::select('id', 'ora')
                    ->whereHas('cursa', function ($query) use ($search_oras){
                            $query->where('plecare_id', '=', $search_oras);
                    })
                    ->get();
                foreach ($raspuns as $r){
                    $r->ora = \Carbon\Carbon::parse($r->ora)->format('H:i');
                };
                break;
            default:
                break;  
        }

        return response()->json([
            'raspuns' => $raspuns
        ]);
    }

}
