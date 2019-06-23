@component('mail::message')
# Buna ziua {{ $rezervari->nume }},
<br>
Va trimitem atasat biletul rezervarii
<br><br>
{{-- @component('mail::button', ['url' => url( $rezervari->path() . '/export/rezervare-pdf')])
Descarcă biletul
@endcomponent --}}
Va multumim pentru ca ati folosit serviciile noastre.
<br><br>
O zi buna!
<br><br><br>
Nu raspundeti la acest email. Raspunsul dvs. nu va fi citit.<br>
Do not respond to this message.Your reply will go nowhere. 
<br><br>
ZUZU Transfer-Aeroport <br>
Contact: <br>
+40 748 836 345 <br>
+40 766 862 890 <br>
+40 767335 558 <br>
+40 786 574 788 <br>
Email: carabus25@yahoo.com

{{-- Multumim,<br>
{{ config('app.name') }} --}}
@endcomponent