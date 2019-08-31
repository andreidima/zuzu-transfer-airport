<?php

namespace App\Http\Controllers;

use App\Traseu;
use App\TraseuNume;
use App\CursaOra;
use Illuminate\Http\Request;
use App\CursaOraTraseu;
use App\Rezervare;
use App\ClientNeserios;

class TraseuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Se afiseaza rapoartele tur
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = \Request::get('search');
        if (empty($search)) {
            $search = \Carbon\Carbon::today()->format('Y-m-d');
        }
        $trasee_nume_tecuci_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 1)
            ->with(
                // 'trasee.curse_ore.cursa', 
                // 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii',
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query->where('data_cursa', $search)
                        ->where('activa', 1);
                }],
                'trasee.rezervari:nr_adulti,nr_copii',
                'trasee.rezervari.user',
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa',
                'trasee.curse_ore'
            )
            // ->with('trasee.curse_ore.cursa')
            ->get();
        $trasee_nume_galati_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 2)
            ->with(
                // 'trasee.curse_ore.cursa', 
                // 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii',
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query->where('data_cursa', $search)
                        ->where('activa', 1);
                }],
                'trasee.rezervari:nr_adulti,nr_copii',
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa',
                'trasee.curse_ore'
            )
            ->get();
        // $trasee_nume_otopeni = TraseuNume::select('id', 'nume')
        //     ->where('id', 3)
        //     ->get();
            
        return view('trasee.index', compact('trasee_nume_tecuci_otopeni', 'trasee_nume_galati_otopeni', 'search'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_retur()
    {
        $search = \Request::get('search');
        if (empty($search)) {
            $search = \Carbon\Carbon::today()->format('Y-m-d');
        }
        $trasee_nume_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 3)
            ->with(
                // 'trasee.curse_ore.cursa', 
                // 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii',
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query->where('data_cursa', $search)
                        ->where('activa', 1);
                }],
                'trasee.rezervari:nr_adulti,nr_copii',
                'trasee.curse_ore.cursa.oras_plecare',
                'trasee.curse_ore.cursa.oras_sosire',
                'trasee.curse_ore.cursa',
                'trasee.curse_ore'
            )
            ->get();

        return view('trasee.index_retur', compact('trasee_nume_otopeni', 'search'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_statistica()
    {
        $search = \Request::get('search');
        if (empty($search)) {
            $search = \Carbon\Carbon::today()->format('Y-m-d');
        }
        $trasee_nume_tecuci_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 1)
            ->with(
                [
                    'trasee.rezervari' => function ($query) use ($search) {
                        $query
                            ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                            ->where('data_cursa', $search)
                            ->where('activa', 1);
                    },
                    'trasee.curse_ore'
                ]
            )
            // ->with('trasee.curse_ore', 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii')
            ->get();
        $trasee_nume_galati_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 2)
            ->with(
                [
                    'trasee.rezervari' => function ($query) use ($search) {
                        $query
                            ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                            ->where('data_cursa', $search)
                            ->where('activa', 1);
                    },
                    'trasee.curse_ore'
                ]
            )
            // ->with('trasee.curse_ore', 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii')
            ->get();
        $trasee_nume_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 3)
            ->with(
                ['trasee.rezervari' => function ($query) use ($search) {
                    $query
                        ->select('data_cursa', 'activa', 'nr_adulti', 'nr_copii')
                        ->where('data_cursa', $search)
                        ->where('activa', 1);
                },
                'trasee.curse_ore'
            ])
            // ->with('trasee.curse_ore', 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii')
            ->get();


        return view('trasee.index_statistica', compact('trasee_nume_tecuci_otopeni', 'trasee_nume_galati_otopeni', 'trasee_nume_otopeni', 'search'));
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
     * @param  \App\traseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, traseu $trasee, $data_traseu)
    {
        $search = \Request::get('search'); //<-- we use global request to get the param of URI
        if (!empty($search)) {
            $search = \Carbon\Carbon::createFromFormat('Y.m.d H:i', $search)->format('Y-m-d');
        } else {
            $search = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');
        }

        // if (($trasee->traseu_nume->id == 2) or ( $trasee->traseu_nume->id == 4)) {
        //     $rezervari = Rezervare::with('cursa', 'ora')
        //         ->whereHas('cursa', function ($query) {
        //             $query->where('plecare_id', '=', 8);
        //         })
        //         ->whereHas('ora', function ($query) use ($trasee){
        //             $query->where('ora', '=', $trasee->curse_ore->first()->ora);
        //         })
        //         ->where('data_cursa', $search)
        //         ->where('activa', 1)
        //         ->latest()
        //         ->get()
        //         ->sortBy(function ($rezervare) {
        //             return [$rezervare->ora->ora, $rezervare->cursa->durata];
        //         });
        //     return view('trasee.show', compact('trasee', 'rezervari', 'search'));
        // }
        // else{
        //     return view('trasee.show', compact('trasee', 'search'));
        // }

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        $rezervari = $trasee->rezervari()
                ->where('data_cursa', $search)
                ->where('activa', 1)
                ->with('cursa', 'cursa.oras_plecare', 'cursa.oras_sosire', 'ora', 'statie', 'tip_plata', 'user')
                ->simplePaginate(100);


        return view('trasee.show', compact('trasee', 'rezervari', 'search', 'telefoane_clienti_neseriosi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\traseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function show_toate_orele(Request $request, $traseu_nume_id, $data_traseu)
    {
        $search = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');

        // if (($traseu_nume_id == 2) or ( $traseu_nume_id == 4) ) {
        //     $trasee_nume = TraseuNume::select('id', 'nume')
        //         ->where('id', 2)
        //         ->first();            

        //     $rezervari = Rezervare::with('cursa', 'ora')
        //         ->whereHas('cursa', function ($query) {
        //                 $query->where('plecare_id', '=', 8);
        //             })
        //         ->where('data_cursa', $search)
        //         ->where('activa', 1)
        //         ->latest()
        //         ->get()
        //         ->sortBy(function ($rezervare) {
        //             return [$rezervare->ora->ora, $rezervare->cursa->durata];
        //         });

        //     return view('trasee.show_toate_orele', compact('trasee_nume', 'rezervari', 'search'));
        // }
        // else {
        //     $trasee_nume = TraseuNume::select('id', 'nume')
        //     ->where('id', $traseu_nume_id)
        //     ->first();

        //     return view('trasee.show_toate_orele', compact('trasee_nume', 'search'));
        // }

        $trasee_nume = TraseuNume::select('id', 'nume')
        ->where('id', $traseu_nume_id)
        ->with('trasee.curse_ore', 'trasee.curse_ore.cursa', 
                'trasee.curse_ore.rezervari.ora', 'trasee.curse_ore.rezervari.tip_plata', 'trasee.curse_ore.rezervari.statie:id,nume',
                'trasee.curse_ore.rezervari.cursa.oras_plecare', 'trasee.curse_ore.rezervari.cursa.oras_sosire',
                'trasee.curse_ore.rezervari.user:id,user_firma_id,nume')
        // ->with('trasee.curse_ore', 'trasee.curse_ore.cursa', 'trasee.curse_ore.cursa.oras_plecare', 'trasee.curse_ore.cursa.oras_sosire', 
        //     'trasee.rezervari', 'trasee.rezervari.user', 'trasee.rezervari.user.firma'
        // )
        // ->with('trasee.rezervari')
        // ->with('trasee.curse_ore.cursa', 'trasee.rezervari', 'trasee.rezervari.tip_plata')        
        // ->with('trasee.curse_ore.cursa', 'trasee.curse_ore', 'trasee.rezervari:data_cursa,activa,nr_adulti,nr_copii')
        ->get();

        // dd($trasee_nume);

            

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        // $rezervari = $trasee->rezervari()
        //         ->where('data_cursa', $search)
        //         ->where('activa', 1)
        //         ->with('cursa', 'cursa.oras_plecare', 'cursa.oras_sosire', 'ora', 'statie', 'tip_plata', 'user')
        //         ->simplePaginate(100);

        return view('trasee.show_toate_orele', compact('trasee_nume', 'search', 'telefoane_clienti_neseriosi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\traseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function edit(traseu $traseu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\traseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, traseu $traseu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\traseu  $traseu
     * @return \Illuminate\Http\Response
     */
    public function destroy(traseu $traseu)
    {
        //
    }

    public function pdfexport(Request $request, Traseu $trasee, $data_traseu)
    {
        $data_traseu_Ymd = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');
        $data_traseu = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('d.m.Y');

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        if ($request->view_type === 'traseu-html') {
            return view('trasee.export.traseu-pdf', compact('trasee', 'data_traseu', 'data_traseu_Ymd', 'telefoane_clienti_neseriosi'));
        } elseif ($request->view_type === 'traseu-pdf') {
            // $pdf->render();

            $pdf = \PDF::loadView('trasee.export.traseu-pdf', compact('trasee', 'data_traseu', 'data_traseu_Ymd', 'telefoane_clienti_neseriosi'))
                ->setPaper('a4');
            return $pdf->stream('Raport ' . $trasee->traseu_nume->nume . ', ' . $data_traseu . ', ' . 
                \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)->format('H_i') 
                . ' - ' .
                \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)
                    ->addHours(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->hour)
                    ->addMinutes(\Carbon\Carbon::parse($trasee->curse_ore->first()->cursa->durata)->minute)
                    ->format('H_i')
                    . 
                    '.pdf');
            
        }
    }

    public function pdfexport_toate_orele(Request $request, $traseu_nume_id, $data_traseu)
    {
        $data_traseu_Ymd = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');
        $data_traseu = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('d.m.Y');

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        $trasee_nume = TraseuNume::select('id', 'nume')
            ->where('id', $traseu_nume_id)
            ->first();
        
        if ($request->view_type === 'traseu-html-toate-orele') {
            return view('trasee.export.traseu-pdf-toate-orele', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd', 'telefoane_clienti_neseriosi'));
        } elseif ($request->view_type === 'traseu-pdf-toate-orele') {            
            $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd', 'telefoane_clienti_neseriosi'))
                ->setPaper('a4');
            return $pdf->stream('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');

        } elseif ($request->view_type === 'traseu-pdf-toate-orele-per-ora') {
            $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele-per-ora', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd', 'telefoane_clienti_neseriosi'))
                ->setPaper('a4');
            return $pdf->stream('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');
            
        }
    }
}
