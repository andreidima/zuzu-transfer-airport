<?php

namespace App\Http\Controllers;

use App\UserFirma;
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
    public function show(UserFirma $userFirma)
    {
        //
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
    public function destroy(UserFirma $userFirma)
    {
        $this->authorize('update', $userFirma);
        $userFirma->delete();
        return redirect('/agentii');
        dd();
    }
}
