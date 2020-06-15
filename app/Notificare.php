<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificare extends Model
{
    protected $table = 'notificari';
    protected $guarded = [];

    public function path()
    {
        return "/notificari/{$this->id}";
    }
}
