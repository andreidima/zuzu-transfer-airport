<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cursa extends Model
{
    protected $table = 'curse';
    protected $guarded = [];

    // public function traseu()
    // {
    //     return $this->belongsTo('App\Traseu', 'traseu_id');
    // }

    public function oras_plecare()
    {
        return $this->belongsTo('App\Oras', 'plecare_id')->withDefault();
    }

    public function oras_sosire()
    {
        return $this->belongsTo('App\Oras', 'sosire_id')->withDefault();
    }

    public function ore()
    {
        return $this->hasMany('App\CursaOra', 'cursa_id');
    }

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'cursa_id');
    }
}
