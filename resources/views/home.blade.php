@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @foreach ($orase as $oras)
                @foreach ($oras->statii as $statie)
                    <p>{{ $oras->nume }} - {{ $statie->nume }}</p>
                @endforeach
            @endforeach
        </div>
        <div class="col-md-4">
            @foreach ($orase_statii as $statie)
                    <p>{{ $statie->nume }} - {{ $statie->oras->nume }}</p>
            @endforeach
        </div>
        <div class="col-md-12">
            <div class="row">
            @foreach ($curse as $cursa)
                <div class="col-md-3">
                {{ $cursa->oras_plecare->nume }} -
                {{ $cursa->oras_sosire->nume }} -
                {{ $cursa->durata }}
                <br>
                <table>
                    <tr>
                        <td>
                    @foreach ($cursa->ore as $ora)
                            {{ \Carbon\Carbon::parse($ora->ora)->format('H:i') }} - 
                            {{ \Carbon\Carbon::today()
                                ->addHours(\Carbon\Carbon::parse($ora->ora)->hour)
                                ->addMinutes(\Carbon\Carbon::parse($ora->ora)->minute)
                                ->addHours(\Carbon\Carbon::parse($cursa->durata)->hour)
                                ->addMinutes(\Carbon\Carbon::parse($cursa->durata)->minute)
                                ->format('d.m.Y, H:i') }}    
                            <br>                  
                    @endforeach
                        </td>
                    </tr>
                </table>
                plecare la {{ \Carbon\Carbon::parse($cursa->durata)->format('d.m.Y, H:i') }}|
                sosire la 
                <span class="text-danger"><strong>
                    {{ \Carbon\Carbon::now()
                        ->addHours(\Carbon\Carbon::parse($cursa->durata)->hour)
                        ->addMinutes(\Carbon\Carbon::parse($cursa->durata)->minute)
                        ->format('d.m.Y, H:i') }}
                </strong></span>|                
                {{ \Carbon\Carbon::now()
                        ->addHours(\Carbon\Carbon::parse($cursa->durata)->hour)
                        ->addMinutes(\Carbon\Carbon::parse($cursa->durata)->minute)
                        ->diffForHumans(now())
                }}
                <br>
                </div>
            @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    @php
                        $cursa_id = App\Cursa::all()->random()->id;
                        $cursa = App\Cursa::all()->where('id', $cursa_id);
                        $oras_id = App\Cursa::select('plecare_id')
                            ->where('id', $cursa_id)->first()->plecare_id;
                        $ora_plecare = App\CursaOra::select('ora')
                            ->where('cursa_id', $cursa_id)->get()->random()->ora;
                    @endphp
                    Cursa id={{$cursa_id}}
                    <br>
                    Cursa = {{$cursa}}
                    <br>
                    Oras id={{$oras_id}}
                    <br>
                    Ora plecare = {{$ora_plecare}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
