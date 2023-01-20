<?php

namespace App\Http\Controllers;

use App\UserFirma;
use App\Rezervare;
use Illuminate\Http\Request;

class UserFirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agentii = UserFirma::with('useri')->orderBy('nume')->get();

        return view('agentii.index', compact('agentii'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agentii.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agentie = UserFirma::create($this->validateRequest($request));

        return redirect('/agentii')->with('status', 'Agenția „' . ($agentie->nume ?? '') . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function show(UserFirma $agentii)
    {
        if (!auth()->user()->isDispecer()) {
            abort(403);
        }
        return view('agentii.show', compact('agentii'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFirma $agentii)
    {
        return view('agentii.edit', compact('agentii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFirma $agentii)
    {
        $agentii->update($this->validateRequest($request));

        return redirect('/agentii')->with('status', 'Agenția „' . ($agentii->nume ?? '') . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFirma $agentii)
    {
        $this->authorize('update', $agentii);
        if ($agentii->useri->count() === 0){
            $agentii->delete();
            return redirect('/agentii')->with('status', 'Agenția a fost ștearsă cu succes');
        } else{
            return redirect('/agentii')->with('error', 'Agenția nu poate fi ștearsă pentru că are conturi adăugate. Ștergeți întâi conturile acestei agenții. Đacă doriți doar ca agenția sa nu mai aibă acces în sistem, este de ajuns să-i modificați conturile (utilizator sau parolă)');
        }

    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate(
            [
                'nume' => 'required|max:150',
                'punct_lucru' => 'nullable|max:150',
                'cif' => 'nullable|max:100',
                'nr_orc' => 'nullable|max:100',
                'persoana_contact' => 'nullable|max:150',
                'telefon' => 'nullable|max:100',
                'email' => 'nullable|max:150',
            ],
            [

            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function rezervari(UserFirma $agentii = null, $search_data_inceput = null, $search_data_sfarsit = null)
    {
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI

        if (auth()->user()->isDispecer()) {
            if(isset($search_data_inceput) && isset($search_data_sfarsit)) {
                $rezervari = $agentii->rezervari()
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->with(
                        'cursa.oras_plecare',
                        'cursa.oras_sosire',
                        // 'ora',
                        'tip_plata',
                        'statie'
                    )
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where('data_cursa', '<=', $search_data_sfarsit)
                    ->orderBy('cursa_id')
                    ->simplePaginate(100)
                    ->appends(request()->query());
            } else {
                $rezervari = $agentii->rezervari()
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->with(
                        'cursa.oras_plecare',
                        'cursa.oras_sosire',
                        // 'ora',
                        'tip_plata',
                        'statie'
                    )
                    ->latest()
                    ->simplePaginate(100)
                    ->appends(request()->query());
            }
        } else {
            if (isset($search_data_inceput) && isset($search_data_sfarsit)) {
                $rezervari = auth()->user()->rezervari()
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->with(
                        'cursa.oras_plecare',
                        'cursa.oras_sosire',
                        // 'ora',
                        'tip_plata',
                        'statie'
                    )
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where('data_cursa', '<=', $search_data_sfarsit)
                    // ->orderBy('cursa_id')
                    ->orderBy('data_cursa')
                    ->simplePaginate(100)
                    ->appends(request()->query());
            } else {
                $rezervari = auth()->user()->rezervari()
                    ->join('curse_ore', 'ora_id', '=', 'curse_ore.id')
                    ->select('rezervari.*', 'curse_ore.ora')
                    ->with(
                        'cursa.oras_plecare',
                        'cursa.oras_sosire',
                        // 'ora',
                        'tip_plata',
                        'statie'
                    )
                    ->latest()
                    ->simplePaginate(100)
                    ->appends(request()->query());
            }
        }
        // dd($agentii, $rezervari);

        return view('agentii.rezervari', compact('agentii', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'));
    }

    public function pdfexport_rezervari_dispecer(Request $request, $agentii = null, $view_type = null, $search_data_inceput = null, $search_data_sfarsit = null)
    {
        $agentie = UserFirma::select('id', 'nume')
            ->where('id', $agentii)
            ->first();

        if ($search_data_inceput && $search_data_sfarsit){
            $rezervari = $agentie->rezervari()
                ->select('rezervari.id', 'rezervari.nume', 'cursa_id', 'data_cursa', 'pret_total', 'tip_plata_id', 'comision_agentie', 'statie_imbarcare', 'nr_adulti', 'nr_copii', 'oferta', 'tur_retur')
                ->where('data_cursa', '>=', $search_data_inceput)
                ->where('data_cursa', '<=', $search_data_sfarsit)
                ->where('activa', 1)
                ->with(
                    'cursa.oras_plecare',
                    'cursa.oras_sosire'
                )
                ->orderBy('cursa_id')
                ->get();
        }


        // dd($search_data_inceput, $search_data_sfarsit);
        // dd($agentie, $rezervari, $agentie->rezervari()->get());

        if ($request->view_type === 'agentie-rezervari-html') {
            return view('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'));
        } elseif ($request->view_type === 'agentie-rezervari-pdf') {
            $pdf = \PDF::loadView('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'))
                ->setPaper('a4');
            return $pdf->download($agentie->nume . ', ' . $search_data_inceput . ' - ' . $search_data_sfarsit . '.pdf');
        }
    }

    public function pdfexport_rezervari_agentie(Request $request, $view_type = null, $search_data_inceput = null, $search_data_sfarsit = null)
    {
        $agentie = UserFirma::select('id', 'nume')
            ->where('id', auth()->user()->firma->id)
            ->first();

        if (isset($search_data_inceput) && isset($search_data_sfarsit)) {
            $rezervari = auth()->user()->rezervari()
                ->select('rezervari.id', 'rezervari.nume', 'cursa_id', 'data_cursa', 'pret_total', 'tip_plata_id', 'comision_agentie', 'statie_imbarcare', 'nr_adulti', 'nr_copii', 'oferta', 'tur_retur')
                ->where('data_cursa', '>=', $search_data_inceput)
                ->where('data_cursa', '<=', $search_data_sfarsit)
                ->where('activa', 1)
                ->with(
                    'cursa.oras_plecare',
                    'cursa.oras_sosire'
                )
                // ->orderBy('cursa_id')
                ->orderBy('data_cursa')
                // ->simplePaginate(100)
                ->get();
                // ->appends(request()->query());
        }

        // dd(auth()->user()->rezervari()->get());

        if ($request->view_type === 'agentie-rezervari-html') {
            return view('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'));
        } elseif ($request->view_type === 'agentie-rezervari-pdf') {
            $pdf = \PDF::loadView('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'))
                ->setPaper('a4');
            return $pdf->download($agentie->nume . ', ' . $search_data_inceput . ' - ' . $search_data_sfarsit . '.pdf');
        }
    }
}
