<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BiletClient extends Mailable
{
    use Queueable, SerializesModels;

    public $rezervari;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rezervari)
    {
        $this->rezervari = $rezervari;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        // return $this->from('bilet@zuzu-transfer-aeroport.ro')
        return $this->markdown('mail.bilet-client');
    }
}
