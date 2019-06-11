<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrasStatie extends Model
{
    protected $table = 'orase_statii';
    protected $guarded = [];

    public function oras()
    {
        return $this->belongsTo('App\Oras', 'oras_id')->withDefault();
    }

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'statie_id');
    }
}
