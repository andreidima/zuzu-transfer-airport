<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rezervare extends Model
{
    protected $table = 'rezervari';
    protected $guarded = [];
    
    protected $with = ['user'];

    public function path()
    {
        return "/rezervari/{$this->id}";
    }

    public function cursa()
    {
        return $this->belongsTo('App\Cursa', 'cursa_id');
    }

    public function statie()
    {
        return $this->belongsTo('App\OrasStatie', 'statie_id');
    }

    public function ora()
    {
        return $this->belongsTo('App\CursaOra', 'ora_id');
    }

    public function tip_plata()
    {
        return $this->belongsTo('App\TipPlata', 'tip_plata_id')->withDefault();
            // ->withDefault([
            //     'nume' => 'nimic'
            // ]);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function traseu()
    {
        return $this->hasOneThrough(
            'App\Traseu',
            'App\CursaOraTraseu',
            'cursa_ora_id', // Foreign key on users table...
            'id', // Foreign key on posts table...
            'ora_id', // Local key on countries table...
            'traseu_id' // Local key on users table...
        );
    }
}
