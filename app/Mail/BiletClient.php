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

        $rezervare_retur = $this->rezervare_retur;

        if ($rezervare_retur != null){
            $rezervari = $this->rezervare_retur;
            $pdf_retur = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
        }

        if($rezervare_retur === null){
            return $this->markdown('mail.bilet-client')
                ->subject('Rezervare Zuzulica Trans')
                ->attachData($pdf->output(), 'Rezervare Zuzulica Trans.pdf');
        }
        else{
            return $this->markdown('mail.bilet-client')
                ->subject('Rezervare Zuzulica Trans')
                ->attachData($pdf->output(), 'Rezervare tur Zuzulica Trans.pdf')
                ->attachData($pdf_retur->output(), 'Rezervare retur Zuzulica Trans.pdf');
        }
    }
}
