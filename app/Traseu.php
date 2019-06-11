<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traseu extends Model
{
    protected $table = 'trasee';
    protected $guarded = [];

    public function path()
    {
        return "/trasee/{$this->id}";
    }

    // public function curse()
    // {
    //     return $this->hasMany('App\Cursa', 'traseu_id');
    // }

    // public function curse_ore()
    // {
    //     return $this->belongsToMany(CursaOra::class)->withTimestamps();
    // }

    public function curse_ore()
    {
        return $this->belongsToMany('App\CursaOra')
            ->using('App\CursaOraTraseu');
    }

    public function traseu_nume()
    {
        return $this->belongsTo('App\TraseuNume', 'traseu_nume_id');
    }

    public function rezervari()
    {
        return $this->hasManyThrough(
            'App\Rezervare',
            'App\CursaOraTraseu',
            'traseu_id', // Foreign key on users table...
            'ora_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'cursa_ora_id' // Local key on users table...
            // 'traseu_id', // Foreign key on users table...
            // 'cursa_ora_id', // Foreign key on posts table...
            // 'id', // Local key on countries table...
            // 'ora_id' // Local key on users table...
        );
    }
}
