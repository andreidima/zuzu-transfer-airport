<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CursaOraTraseu extends Pivot
{    
    protected $table = 'cursa_ora_traseu';
    protected $guarded = [];

    public function trasee()
    {
        return $this->belongsTo('App\Traseu');
    }
    
    public function curse_ore()
    {
        return $this->belongsTo('App\CursaOra');
    }
    
    public function rezervari()
    {
        return $this->hasManyThrough('App\Rezervare', 'App\CursaOra');
    }
}
