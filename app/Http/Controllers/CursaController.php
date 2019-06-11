<?php

namespace App\Http\Controllers;

use App\Cursa;
use Illuminate\Http\Request;

class CursaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $curse = Cursa::all();
        // dd($curse);
        return view('curse.index', compact('curse'));
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
     * @param  \App\Cursa  $cursa
     * @return \Illuminate\Http\Response
     */
    public function show(Cursa $cursa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cursa  $cursa
     * @return \Illuminate\Http\Response
     */
    public function edit(Cursa $cursa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cursa  $cursa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cursa $cursa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cursa  $cursa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cursa $cursa)
    {
        //
    }
}
