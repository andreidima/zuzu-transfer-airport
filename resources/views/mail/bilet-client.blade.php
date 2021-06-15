@component('mail::message')
# Buna {{ $rezervari->nume }},
<br>
Iti trimitem atasat biletul rezervarii
<br><br>
{{-- @component('mail::button', ['url' => url( $rezervari->path() . '/export/rezervare-pdf')])
Descarcă biletul
@endcomponent --}}
Iti multumim pentru ca ai folosit serviciile noastre.
<br><br><br>
Nu raspunde la acest email. Raspunsul tau nu va fi citit.<br>
Do not respond to this message. Your reply will go nowhere.
<br><br>
Zuzu Transfer Airport <br>
Contact: <br>
+40 0768 112 244 <br>
+40 0768 112 255 <br>
+40 0768 112 288 <br>
Email: rezervari@zuzu-transfer-airport.ro

{{-- Multumim,<br>
{{ config('app.name') }} --}}
@endcomponent
