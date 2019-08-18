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
        $agentii = UserFirma::all();
        
        return view('agentii.index', compact('agentii'));
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
    public function edit(UserFirma $userFirma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFirma  $userFirma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFirma $userFirma)
    {
        //
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
        $agentii->delete();
        return redirect('/agentii');
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
                    ->with('cursa', 'ora', 'tip_plata', 'statie')
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where('data_cursa', '<=', $search_data_sfarsit)
                    ->orderBy('cursa_id')
                    ->simplePaginate(100)
                    ->appends(request()->query());                    
            } else {
                $rezervari = $agentii->rezervari()
                    ->with('cursa', 'ora', 'tip_plata', 'statie')
                    ->latest()
                    ->simplePaginate(100)
                    ->appends(request()->query());
            }
        } else {
            if (isset($search_data_inceput) && isset($search_data_sfarsit)) {
                $rezervari = auth()->user()->rezervari()
                    ->with('cursa', 'ora', 'tip_plata', 'statie')
                    ->where('data_cursa', '>=', $search_data_inceput)
                    ->where('data_cursa', '<=', $search_data_sfarsit)
                    ->orderBy('cursa_id')
                    ->simplePaginate(100)
                    ->appends(request()->query());
            } else {
                $rezervari = auth()->user()->rezervari()
                    ->with('cursa', 'ora', 'tip_plata', 'statie')
                    ->latest()
                    ->simplePaginate(100)
                    ->appends(request()->query());
            }
        }
        // dd($agentii, $rezervari);

        return view('agentii.rezervari', compact('agentii', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'));
    }

    public function pdfexport_rezervari_dispecer(Request $request, $agentii = null, $search_data_inceput = null, $search_data_sfarsit = null)
    {            
        $agentie = UserFirma::select('id', 'nume')
            ->where('id', $agentii)
            ->first();

        if ($search_data_inceput && $search_data_sfarsit){
            $rezervari = $agentie->rezervari()
                ->where('data_cursa', '>=', $search_data_inceput)
                ->where('data_cursa', '<=', $search_data_sfarsit)
                ->where('activa', 1)
                ->orderBy('cursa_id')
                ->get();
        }

        $pdf = \PDF::loadView('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'))
            ->setPaper('a4');
        return $pdf->stream($agentie->nume . ', ' . $search_data_inceput . ' - ' . $search_data_sfarsit . '.pdf');
    }

    public function pdfexport_rezervari_agentie(Request $request, $search_data_inceput = null, $search_data_sfarsit = null)
    { 
        $agentie = UserFirma::select('id', 'nume')
            ->where('id', auth()->user()->firma->id)
            ->first();  

        if (isset($search_data_inceput) && isset($search_data_sfarsit)) {
            $rezervari = auth()->user()->rezervari()
                ->where('data_cursa', '>=', $search_data_inceput)
                ->where('data_cursa', '<=', $search_data_sfarsit)
                ->where('activa', 1)
                ->orderBy('cursa_id')
                ->simplePaginate(100)
                ->appends(request()->query());
        }

        $pdf = \PDF::loadView('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'))
            ->setPaper('a4');
        return $pdf->stream($agentie->nume . ', ' . $search_data_inceput . ' - ' . $search_data_sfarsit . '.pdf');
    }
}