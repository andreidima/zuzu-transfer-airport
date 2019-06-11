<?php

namespace App\Http\Controllers;

use App\Oras;
use App\OrasStatie;
use App\Cursa;
use App\CursaOra;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orase = Oras::all();
        $orase_statii = OrasStatie::all();
        $curse = Cursa::all();
        // $curse = Cursa::find(1);
        $curse_ore = CursaOra::find(1);
        // dd($curse_ore->cursa);
        return view('home', compact('orase', 'orase_statii', 'curse'));
    }
}
