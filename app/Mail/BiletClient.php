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
    public function __construct($rezervari, $rezervare_retur = null)
    {
        $this->rezervari = $rezervari;
        $this->rezervare_retur = $rezervare_retur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $rezervari = $this->rezervari;
        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
            ->setPaper('a4');

        if ($rezervare_retur != null){
            $rezervari = $this->rezervari;
            $pdf_retur = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
        }

        if($rezervare_retur == null){
            return $this->markdown('mail.bilet-client')
                ->attachData($pdf->output(), 'Rezervare Zuzu Transfer Aeroport.pdf');
        }
        else{
            return $this->markdown('mail.bilet-client')
                ->attachData($pdf->output(), 'Rezervare tur Zuzu Transfer Aeroport.pdf')
                ->attachData($pdf_retur->output(), 'Rezervare retur Zuzu Transfer Aeroport.pdf');
        }
    }
}
