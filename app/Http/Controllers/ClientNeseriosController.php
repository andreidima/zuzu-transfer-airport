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
        $clienti_neseriosi = ClientNeserios::all();
        // dd ($clienti_neseriosi);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function show(ClientNeserios $clientNeserios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientNeserios $clientNeserios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientNeserios $clientNeserios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientNeserios  $clientNeserios
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientNeserios $clientNeserios)
    {
        //
    }
}
