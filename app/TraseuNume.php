<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraseuNume extends Model
{
    protected $table = 'trasee_nume';
    protected $guarded = [];

    // protected $with = ['trasee.curse_ore'];

    public function trasee()
    {
        return $this->hasMany('App\Traseu', 'traseu_nume_id');
    }
}
