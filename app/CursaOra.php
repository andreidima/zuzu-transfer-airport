<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursaOra extends Model
{
    protected $table = 'curse_ore';
    protected $guarded = [];

    // protected $with = ['cursa', 'rezervari'];
    // protected $with = ['rezervari.user', 'rezervari.tip_plata'];
                // ->with('user', 'cursa.oras_plecare' ,'cursa.oras_sosire', 'tip_plata', 'statie')

    public function cursa()
    {
        return $this->belongsTo('App\Cursa', 'cursa_id');
    }

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'ora_id');
    }

    // public function trasee()
    // {
    //     return $this->belongsToMany(CursaOra::class)->withTimestamps();
    // }

    public function trasee()
    {
        return $this->belongsToMany('App\Traseu')
            ->using('App\CursaOraTraseu');
    }
}
