@php
    $notificari = App\Notificare::where('stare', 1)->get();
    // dd($notificari);
@endphp

@forelse ($notificari as $notificare)
                <div class="form-row mb-2 d-flex justify-content-center">
                    <div class="form-group col-lg-11 card text-dark shadow-sm p-0 mb-1 text-center" style="background-color:#dedede">
                        <h6 class="m-0 p-0">{{ $notificare->text }}</h6>
                    </div>
                </div>
@empty
@endif