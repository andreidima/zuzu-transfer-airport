@php
    $notificari = App\Notificare::where('stare', 1)->get();
    // dd($notificari);
@endphp

@forelse ($notificari as $notificare)
            <div class="row mb-1">
                <div class="col-lg-11 mx-auto d-flex justify-content-center">
                    <div class="card text-dark shadow-sm px-2 p-0 mb-1 text-center" 
                        style="background-color:#dedede; border-color:orange; display: inline-block">
                        <h6 class="m-0 p-0">{{ $notificare->text }}</h6>
                    </div>
                </div>
            </div>
@empty
@endif