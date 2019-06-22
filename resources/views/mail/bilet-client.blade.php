@component('mail::message')
# Rezervare noua: {{ $rezervari->nume }}

{{ $rezervari->pret_total }}

@component('mail::button', ['url' => url('/rezervari/' . $rezervari->id)])
Vezi rezervarea
@endcomponent

Multumim,<br>
{{ config('app.name') }}
@endcomponent