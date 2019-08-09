<?php

namespace App\Http\Controllers;

use App\ClientNeserios;
use Illuminate\Http\Request;

class ClientNeseriosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_client_neserios_telefon = \Request::get('search_client_neserios_telefon'); //<-- we use global request to get the param of URI

        $clienti_neseriosi = ClientNeserios::when($search_client_neserios_telefon, function ($query, $search_client_neserios_telefon) {
                                    return $query->where( 'telefon', 'like', '%' . $search_client_neserios_telefon . '%');
                                })
                ->latest()
                ->get();

        return view('clienti-neseriosi.index', compact('clienti_neseriosi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clienti-neseriosi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_neserios = ClientNeserios::create($this->validateRequest($request));

        return redirect($client_neserios->path())->with('status', 'Clientul neserios "' . $client_neserios->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function show(ClientNeserios $clienti_neseriosi)
    {        
        return view('clienti-neseriosi.show', compact('clienti_neseriosi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientNeserios $clienti_neseriosi)
    {
        return view('clienti-neseriosi.edit', compact('clienti_neseriosi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientNeserios $clienti_neseriosi)
    {
        $this->validateRequest($request, $clienti_neseriosi);
        $clienti_neseriosi->update($request->all());
        
        return redirect($clienti_neseriosi->path())->with('status', 'Clientul neserios "' . $clienti_neseriosi->nume . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientNeserios $clienti_neseriosi)
    {
        $clienti_neseriosi->delete();
        return redirect('/clienti-neseriosi');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $rezervari = null)
    {
        return request()->validate([
            'nume' => ['required', 'max:100'],
            'telefon' => ['required', 'max:100'],            
            'observatii' => ['required', 'max:500']
        ]);
    }

}