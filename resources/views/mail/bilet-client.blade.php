@component('mail::message')
# Buna ziua {{ $rezervari->nume }},

Va trimitem atasat biletul rezervarii
<br>

{{-- @component('mail::button', ['url' => url( $rezervari->path() . '/export/rezervare-pdf')])
Descarcă biletul
@endcomponent --}}


Multumim,<br>
{{ config('app.name') }}
@endcomponent