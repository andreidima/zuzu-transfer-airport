<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oras extends Model
{
    protected $table = 'orase';
    protected $guarded = [];

    public function statii()
    {
        return $this->hasMany('App\OrasStatie', 'oras_id');
    }

    public function curse_plecare()
    {
        return $this->hasMany('App\Cursa', 'plecare_id');
    }

    public function curse_sosire()
    {
        return $this->hasMany('App\Cursa', 'sosire_id');
    }
}
