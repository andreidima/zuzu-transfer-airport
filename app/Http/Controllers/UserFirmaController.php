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
    public function rezervari(UserFirma $agentii)
    {        
        $search_data_inceput = \Request::get('search_data_inceput'); //<-- we use global request to get the param of URI
        $search_data_sfarsit = \Request::get('search_data_sfarsit'); //<-- we use global request to get the param of URI
        
        if(isset($search_data_inceput) && isset($search_data_sfarsit)) {
            $rezervari = $agentii->rezervari()
                ->where('data_cursa', '>=', $search_data_inceput)
                ->where('data_cursa', '<=', $search_data_sfarsit)
                ->orderBy('data_cursa')
                ->simplePaginate(100);
        } else {
            $rezervari = $agentii->rezervari()
                ->orderBy('data_cursa')
                ->simplePaginate(100);
        }

        return view('agentii.rezervari', compact('agentii', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'));
    }

    public function pdfexport_rezervari(Request $request, $agentii, $search_data_inceput, $search_data_sfarsit)
    {
        $agentie = UserFirma::select('id', 'nume')
            ->where('id', $agentii)
            ->first();
        $rezervari = Rezervare::all()
            ->where('data_cursa', '>=', $search_data_inceput)
            ->where('data_cursa', '<=', $search_data_sfarsit)
            ->where('activa', 1);
            
        // dd($request, $agentii, $search_data_inceput, $search_data_sfarsit);
        // dd($agentie, $rezervari);
        
        if ($request->view_type === 'agentie-rezervari-pdf') {
            $pdf = \PDF::loadView('agentii.export.agentie-rezervari-pdf', compact('agentie', 'rezervari', 'search_data_inceput', 'search_data_sfarsit'))
                ->setPaper('a4');
            return $pdf->stream('Raport ' . $agentie->nume . ', ' . $search_data_inceput . ' - ' . $search_data_sfarsit . '.pdf');
        }
    }
}
