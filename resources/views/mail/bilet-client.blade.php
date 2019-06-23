@component('mail::message')
# Rezervare noua: {{ $rezervari->nume }}

{{ $rezervari->pret_total }}

@component('mail::button', ['url' => url( $rezervari->path() . '/export/rezervare-pdf')])
Descarcă biletul
@endcomponent


Multumim,<br>
{{ config('app.name') }}
@endcomponent