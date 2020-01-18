<?php

namespace App\Http\Controllers;

use App\SmsTrimis;
use Illuminate\Http\Request;

class SmsTrimisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI   
        $search_data_inceput = \Request::get('search_data_inceput');
        $search_data_sfarsit = \Request::get('search_data_sfarsit');
        $sms_trimise = SmsTrimis::with('rezervare')
            ->whereHas('rezervare', function ($query) use ($search_nume) {
                $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_data_inceput, function ($query, $search_data_inceput) {
                return $query->whereDate('created_at', '>=', $search_data_inceput);
            })
            ->when($search_data_sfarsit, function ($query, $search_data_sfarsit) {
                return $query->whereDate('created_at', '<=', $search_data_sfarsit);
            })
            ->latest()
            ->simplePaginate(25);

        return view(
            'sms-trimise.index',
            compact('sms_trimise', 'search_nume', 'search_data_inceput', 'search_data_sfarsit')
        );
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
     * @param  \App\SmsTrimis  $smsTrimis
     * @return \Illuminate\Http\Response
     */
    public function show(SmsTrimis $smsTrimis)
    {
        return view('sms-trimise.show', compact('sms_trimise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SmsTrimis  $smsTrimis
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsTrimis $smsTrimis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SmsTrimis  $smsTrimis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmsTrimis $smsTrimis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SmsTrimis  $smsTrimis
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsTrimis $smsTrimis)
    {
        //
    }
}
