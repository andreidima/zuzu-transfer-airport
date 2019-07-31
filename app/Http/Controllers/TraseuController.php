<?php

namespace App\Http\Controllers;

use App\Traseu;
use App\TraseuNume;
use App\CursaOra;
use Illuminate\Http\Request;
use App\CursaOraTraseu;
use App\Rezervare;

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
            ->get();
        $trasee_nume_galati_otopeni = TraseuNume::select('id', 'nume')
            ->where('id', 2)
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
            ->get();

        return view('trasee.index_retur', compact('trasee_nume_otopeni', 'search'));
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

        if (($trasee->traseu_nume->id == 2) or ( $trasee->traseu_nume->id == 4)) {
            $rezervari = Rezervare::with('cursa', 'ora')
                ->whereHas('cursa', function ($query) {
                    $query->where('plecare_id', '=', 8);
                })
                ->whereHas('ora', function ($query) use ($trasee){
                    $query->where('ora', '=', $trasee->curse_ore->first()->ora);
                })
                ->where('data_cursa', $search)
                ->where('activa', 1)
                ->latest()
                ->get()
                ->sortBy(function ($rezervare) {
                    return [$rezervare->ora->ora, $rezervare->cursa->durata];
                });
            return view('trasee.show', compact('trasee', 'rezervari', 'search'));
        }
        else{
            return view('trasee.show', compact('trasee', 'search'));
        }
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

        if (($traseu_nume_id == 2) or ( $traseu_nume_id == 4) ) {
            // Id-uri pentru Otopeni-Tecuci si Otopeni-Galati, care se scot cumulat
            $trasee_nume = TraseuNume::select('id', 'nume')
                ->where('id', 2)
                ->first();            

            $rezervari = Rezervare::with('cursa', 'ora')
                ->whereHas('cursa', function ($query) {
                        $query->where('plecare_id', '=', 8);
                    })
                ->where('data_cursa', $search)
                ->where('activa', 1)
                ->latest()
                ->get()
                ->sortBy(function ($rezervare) {
                    return [$rezervare->ora->ora, $rezervare->cursa->durata];
                });

            return view('trasee.show_toate_orele', compact('trasee_nume', 'rezervari', 'search'));
        }
        else {
            // Id-uri ramase sunt 1 si 3, pentru Tecuci-Otopeni si Galati-Otopeni
            $trasee_nume = TraseuNume::select('id', 'nume')
            ->where('id', $traseu_nume_id)
            ->first();

            return view('trasee.show_toate_orele', compact('trasee_nume', 'search'));
        }
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

        if ($request->view_type === 'traseu-html') {
            return view('trasee.export.traseu-pdf', compact('trasee', 'data_traseu', 'data_traseu_Ymd'));
        } elseif ($request->view_type === 'traseu-pdf') {
            // $pdf->render();
            switch($trasee->traseu_nume->id){
                case "1":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf', compact('trasee', 'data_traseu', 'data_traseu_Ymd'))
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
                    break;
                case "2":
                    break;
                case "3":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf', compact('trasee', 'data_traseu', 'data_traseu_Ymd'))
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
                    break;
                case "4":
                    $rezervari = Rezervare::with('cursa', 'ora')
                        ->whereHas('cursa', function ($query) {
                            $query->where('plecare_id', '=', 8);
                        })
                        ->whereHas('ora', function ($query) use ($trasee){
                            $query->where('ora', '=', $trasee->curse_ore->first()->ora);
                        })
                        ->where('data_cursa', $data_traseu_Ymd)
                        ->where('activa', 1)->get()
                        ->sortBy(function ($rezervare) {
                            return [$rezervare->ora->ora, $rezervare->cursa->durata];
                        });
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf', compact('rezervari', 'trasee', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->stream('Raport plecari Otopeni, ' . $data_traseu . ', ' . 
                        \Carbon\Carbon::parse($trasee->curse_ore->first()->ora)->format('H_i') 
                        . '.pdf');
                    break;
                default:
                    echo "Nu sunt informații aici. Contactează administratorul aplicației.";
            }
        }
    }

    public function pdfexport_toate_orele(Request $request, $traseu_nume_id, $data_traseu)
    {
        $data_traseu_Ymd = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('Y-m-d');
        $data_traseu = \Carbon\Carbon::createFromFormat('d-m-Y', $data_traseu)->format('d.m.Y');

        $trasee_nume = TraseuNume::select('id', 'nume')
            ->where('id', $traseu_nume_id)
            ->first();
        
        if ($request->view_type === 'traseu-html-toate-orele') {
            return view('trasee.export.traseu-pdf-toate-orele', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd'));
        } elseif ($request->view_type === 'traseu-pdf-toate-orele') {
            switch($trasee_nume->id){
                case "1":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->stream('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');
                    break;
                case "2":
                    break;
                case "3":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->stream('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');
                    break;
                case "4":
                    break;
                default:
                    echo "Nu sunt informații aici. Contactează administratorul aplicației.";
            }
        } elseif ($request->view_type === 'traseu-pdf-toate-orele-per-ora') {
            switch($trasee_nume->id){
                case "1":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele-per-ora', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->download('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');
                    break;
                case "2":
                    // $rezervari = Rezervare::with('cursa', 'ora')
                    //     ->whereHas('cursa', function ($query) {
                    //         $query->where('plecare_id', '=', 8);
                    //     })
                    //     ->where('data_cursa', $data_traseu_Ymd)
                    //     ->where('activa', 1)->get()
                    //     ->sortBy(function ($rezervare) {
                    //         return [$rezervare->ora->ora, $rezervare->cursa->durata];
                    //     });
                    $curse_ore = CursaOra::with('cursa', 'rezervari')
                        ->whereHas('cursa', function ($query) {
                            $query->where('plecare_id', '=', 8);
                        })
                        ->whereHas('rezervari', function ($query) use ($data_traseu_Ymd){
                            $query->where( 'data_cursa', $data_traseu_Ymd);
                        })
                        ->whereHas('rezervari', function ($query) {
                            $query->where('activa', 1);
                        })
                        ->get()
                        ->sortBy(function ($ora) {
                            return [$ora->ora, $ora->cursa->durata];
                        })
                        ->groupBy(function ($item) {
                            return $item->ora;
                        });
                        //  dd($curse_ore);
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele-per-ora', compact('trasee_nume', 'curse_ore', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->stream('Raport plecari Otopeni, ' . $data_traseu . '.pdf');
                    break;
                case "3":
                    $pdf = \PDF::loadView('trasee.export.traseu-pdf-toate-orele-per-ora', compact('trasee_nume', 'data_traseu', 'data_traseu_Ymd'))
                        ->setPaper('a4');
                    return $pdf->stream('Raport ' . $trasee_nume->nume . ', ' . $data_traseu . '.pdf');
                    break;
                case "4":
                    break;
                default:
                    echo "Nu sunt informații aici. Contactează administratorul aplicației.";
            }
        }
    }
}
