<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RezervareIstoric;
use App\ClientNeserios;

class RezervareIstoricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!((auth()->user()->id == 355) || (auth()->user()->id == 356)))
        {
            return redirect('/rezervari');
        }

        $search_nume_telefon = \Request::get('search_nume_telefon'); //<-- we use global request to get the param of URI
        $search_cod_bilet = \Request::get('search_cod_bilet'); //<-- we use global request to get the param of URI
        // dd($search_cod_bilet);
        
        $rezervari = RezervareIstoric::join('curse_ore', 'ora_id', '=', 'curse_ore.id')
            ->select('rezervari_istoric.*', 'curse_ore.ora')
            ->when($search_nume_telefon, function ($query, $search_nume_telefon) {
                return $query   ->where('nume', 'like', '%' . $search_nume_telefon . '%')
                                ->orWhere('telefon', 'like', '%' . $search_nume_telefon . '%');
            })
            ->when($search_cod_bilet, function ($query, $search_cod_bilet) {
                return $query->where( 'rezervari_istoric.id', $search_cod_bilet);
            })
            ->with('cursa.oras_plecare' ,'cursa.oras_sosire', 'tip_plata', 'statie', 'user.firma:id,nume')
            ->latest('rezervari_istoric.data_operatie')
            ->simplePaginate(100);        

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        return view('rezervari-istoric.index', compact('rezervari', 'telefoane_clienti_neseriosi'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function show(RezervareIstoric $rezervari_istoric)
    {
        // $this->authorize('update', $rezervari);
        // dd($rezervari_istoric);
        $rezervari = $rezervari_istoric;

        $telefoane_clienti_neseriosi = ClientNeserios::pluck('telefon')->all();

        return view('rezervari-istoric.show', compact('rezervari', 'telefoane_clienti_neseriosi'));
    }
}
