<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsTrimis extends Model
{
    protected $table = 'sms_trimise';
    protected $guarded = [];

    public function path()
    {
        return "/sms-trimise/{$this->id}";
    }

    public function rezervare()
    {
        return $this->belongsTo('App\Rezervare', 'rezervare_id');
    }
}
