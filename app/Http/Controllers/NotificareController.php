<?php

namespace App\Http\Controllers;

use App\Notificare;
use Illuminate\Http\Request;

class NotificareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_text = \Request::get('search_text'); //<-- we use global request to get the param of URI  
        $notificari = Notificare::
            when($search_text, function ($query, $search_text) {
                return $query->where('text', 'like', '%' . str_replace(' ', '%', $search_text) . '%');
            })
            ->latest()
            ->Paginate(25);

        return view('notificari.index', compact('notificari', 'search_text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notificari.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notificari = Notificare::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $notificari->stare = 1;
        $notificari->save();

        return redirect('/notificari')->with('status', 'Notificarea "'.$notificari->nume.'" a fost înregistrată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notificare  $notificari
     * @return \Illuminate\Http\Response
     */
    public function show(Notificare $notificari)
    {
        return view('avansuri.show', compact('avansuri'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notificare  $notificari
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificare $notificari)
    {
        return view('notificari.edit', compact('notificari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notificare  $notificari
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificare $notificari)
    {
        // $this->authorize('update', $proiecte);

        $notificari->update($this->validateRequest($notificari));

        return redirect('/notificari')->with('status', 'Notificarea "'.$notificari->text.'" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notificare  $notificari
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificare $notificari)
    {
        $notificari->delete();
        return redirect('/notificari')->with('status', 'Notificarea "' . $notificari->text . '" a fost ștersă cu succes!');
    }    

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'text' =>['required', 'max:900'],
        ]
        );
    }

    public function update_activa_inactiva(Request $request, Notificare $notificari)
    {
        if ( $notificari->stare === 0) {
            $notificari->stare = 1;
        } else {
            $notificari->stare = 0;
        }
        $notificari->update();
        
        return redirect('/notificari');
    }
}
