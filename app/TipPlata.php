<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipPlata extends Model
{
    protected $table = 'tip_plata';
    protected $guarded = [];

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'tip_plata_id');
    }
}
