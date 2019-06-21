@extends('layouts.app')

@section('content')   
    <div class="container card px-0">
        <div class="d-flex justify-content-between card-header">
            <div class="flex flex-vertical-center">
                <h4 class="mt-2"><a href="/agentii"><i class="fas fa-handshake mr-1"></i>Agenții</a> / {{ $agentii->nume }}</h4>
            </div> 
        </div>


        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-7 bg-light border">
                    <table class="table table-sm table-striped">
                        <tr>
                            <td>Nume:</td>
                            <td>
                                {{ $agentii->nume }}
                            </td>
                        </tr>
                        <tr>
                            <td>Sediu:</td>
                            <td>
                                {{ $agentii->punct_lucru }}
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                {{ $agentii->email }}
                            </td>
                        </tr>
                        <tr>
                            <td>Telefon:</td>
                            <td>
                                {{ $agentii->telefon }}
                            </td>
                        </tr>
                        <tr>
                            <td>CIF:</td>
                            <td>
                                {{ $agentii->cif }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nr. ORC:</td>
                            <td>
                                {{ $agentii->nr_orc }}
                            </td>
                        </tr>
                        <tr>
                            <td>Persoana contact:</td>
                            <td>
                                {{ $agentii->persoana_contact }}
                            </td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>

@endsection