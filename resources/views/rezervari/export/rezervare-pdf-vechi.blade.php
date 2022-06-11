<!DOCTYPE  html>
<html lang="ro">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bilet</title>
    <style>
        html {
            margin: 40px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* font-family: Arial, Helvetica, sans-serif; */
            font-size: 12px;
            margin: 0px;
        }

        * {
            /* padding: 0; */
            text-indent: 0;
        }

        table{
            border-collapse:collapse;
            margin: 0px;
            padding: 0px;
            margin-top: 0px;
            border-style: solid;
            border-width: 0px;
            width: 100%;
            word-wrap:break-word;
        }

        th, td {
            padding: 1px 1px;
            border-width: 0px;
            border-style: solid;

        }
        tr {
            border-style: solid;
            border-width: 0px;
        }
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 0.5px;
        }
    </style>
</head>

<body>
    {{-- <div style="width:730px; height: 1030px; border-style: dashed ; border-width:2px; border-radius: 15px;">      --}}
    <div style="border:dashed #999;
        width:710px;
        min-height:600px;
        padding: 0px 8px 0px 8px;
        margin:0px 0px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            border-radius: 10px;">

                <table style="">
                    <tr style="">
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:40%">
                            <img src="{{ asset('images/logo_alb.jpg') }}" width="300px">
                        </td>
                        <td style="border-width:0px; padding:0rem; margin:0rem; width:60%; text-align:center; font-size:16px">
                            REZERVA BILET
                            <br>
                            Cod bilet: RO{{ $rezervari->id }}
                        </td>
                    </tr>
                </table>


            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="3" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:0px 0px 2px 0px; padding:2px 0px;">
                        Informatii Calator
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="">
                        Calator: <b>{{ $rezervari->nume }}</b>
                    </td>
                    <td width="25%" style="text-align:center;">
                        Telefon: <b>{{ $rezervari->telefon }}</b>
                    </td>
                    <td width="40%" style="text-align:right;">
                        E-mail: <b>{{ $rezervari->email }}</b>
                    </td>
                </tr>
            </table>

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="5" style="padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 2px 0px; padding:2px 0px">
                        Informatii Rezervare bilet
                        </h3>
                    </td>
                </tr>
                <tr valign="top">
                    <td style="">
                        Imbarcare:
                        <br>
                        @if (!empty($rezervari->cursa->oras_plecare))
                            @if ($rezervari->cursa->oras_plecare->nume == "Otopeni")
                                <span style="font-size:1.5rem; font-weight:bold;">
                                    Otopeni Aeroport
                                </span>
                            @else
                            <span style="font-size:1.5rem; font-weight:bold;">
                                {{ $rezervari->cursa->oras_plecare->nume }}
                            </span>
                            {{-- <br>
                            <span style="font-size:1.2rem;">
                                @if (!empty($rezervari->statie))
                                    {{ $rezervari->statie->nume }}
                                @else
                                    {{ $rezervari->statie_imbarcare }}
                                @endif
                            </span> --}}
                            @endif
                        @endif
                    </td>
                    <td style="">
                        Plecare:
                        <br>
                        @if (!empty($rezervari->ora))
                            <span style="font-size:1.5rem; font-weight:bold;">
                                {{ \Carbon\Carbon::parse($rezervari->ora->ora)->format('H:i') }}
                            </span>
                        @endif
                        <br>
                        {{-- @if (!empty(auth()->user())) --}}
                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('dddd') }}
                            </span>
                            <br>
                            {{ \Carbon\Carbon::parse($rezervari->data_cursa)->isoFormat('D MMM YYYY') }}
                        {{-- @else
                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)->isoFormat('dddd') }}
                            </span>
                            <br>
                            {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)->isoFormat('D MMM YYYY') }}
                        @endif --}}
                    </td>
                    <td>
                        <br>
                        <img src="{{ asset('images/sageata.gif') }}" width="50px">
                    </td>
                    <td style="">
                        Debarcare:
                        <br>
                        @if (!empty($rezervari->cursa->oras_sosire))
                            @if ($rezervari->cursa->oras_sosire->nume == "Otopeni")
                                <span style="font-size:1.5rem; font-weight:bold;">
                                    Otopeni Aeroport
                                </span>
                            @else
                            <span style="font-size:1.5rem; font-weight:bold;">
                                {{ $rezervari->cursa->oras_sosire->nume }}
                            </span>
                            @endif
                        @endif
                    </td>
                    <td style="">
                        Sosire:
                        <br>
                        @if (!empty($rezervari->ora && $rezervari->cursa->durata))
                            <span style="font-size:1.5rem; font-weight:bold;">
                                {{ \Carbon\Carbon::parse($rezervari->ora->ora)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->format('H:i') }}
                            </span>
                        @endif
                        <br>

                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->isoFormat('dddd') }}
                            </span>
                            <br>
                                {{ \Carbon\Carbon::parse($rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->isoFormat('D MMM YYYY') }}
                        {{-- @else
                            <span style="font-size:1.2rem;">
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->isoFormat('dddd') }}
                            </span>
                            <br>
                                {{ \Carbon\Carbon::createFromFormat('Y.m.d H:i', $rezervari->data_cursa)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->ora->ora)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->ora->ora)->minute)
                                    ->addHours(\Carbon\Carbon::parse($rezervari->cursa->durata)->hour)
                                    ->addMinutes(\Carbon\Carbon::parse($rezervari->cursa->durata)->minute)
                                    ->isoFormat('D MMM YYYY') }}
                        @endif --}}
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        Statie imbarcare:
                        @if (!empty($rezervari->statie))
                            {{ $rezervari->statie->nume }}
                        @else
                            {{ $rezervari->statie_imbarcare }}
                        @endif
                    </td>
                </tr>
            </table>

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan="6" style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 0px 0px; padding:2px 0px">
                        Calatorie | Tarif
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Pret per adult
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Pret per copil
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Adulti
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Copii
                    </td>
                    <td colspan="2" style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        Valoare
                    </td>
                </tr>
                <tr style="text-align:center">
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->cursa->pret_adult }} lei
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->cursa->pret_copil }} lei
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->nr_adulti }}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->nr_copii }}
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">
                        {{ $rezervari->pret_total }} lei
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px;">

                    </td>
                </tr>
                {{-- <tr>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 5px 0 5px; text-align:right;">
                        Total
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px; text-align:center;">
                        {{ $rezervari->pret_total }} lei
                    </td>
                </tr> --}}
                <tr>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 5px 0 5px; text-align:right;">
                        Achitat:
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px; text-align:center;">
                        @if ($rezervari->tip_plata_id == 3)
                            {{ $rezervari->pret_total }}
                        @elseif (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                            {{ $rezervari->pret_total }}
                        @else
                            {{ $rezervari->comision_agentie - 0}}
                        @endif
                        lei
                    </td>
                </tr>
                <tr>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:0px; padding: 0 0 0 5px;">

                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 5px 0 5px; text-align:right;">
                        Rest de plata:
                    </td>
                    <td style="border-style: solid; border-width:1px; padding: 0 0 0 5px; text-align:center;">
                        @if ($rezervari->tip_plata_id == 3)
                            0
                        @elseif (($rezervari->comision_agentie == 0) && ($rezervari->tip_plata_id == 2))
                            0
                        @else
                            {{ $rezervari->pret_total - $rezervari->comision_agentie }}
                        @endif
                        lei
                    </td>
                </tr>
            </table>

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 2px 0px; padding:2px 0px">
                        Operator Transport
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Zuzulica Trans</b><br>
                        Traseu 1: Tecuci - Focsani - Rm. Sarat - Buzau - Otopeni si retur<br>
                        Traseu 2: Galati - Braila - Ianca - Buzau - Otopeni si retur<br>
                        {{-- Telefon sofer: +40 762 646 917, +40 767 931 404<br> --}}
                        Telefon Dispecerat: <br>
                        E-mail:  |
                        Website: www.zuzu-transfer-airport.ro
                    </td>
                </tr>
            </table>

            <table>
                <tr style="text-align:center; font-weight:bold;">
                    <td style="border-width:0px; padding:0rem;">
                        <h3 style="background-color:#e7d790; color:black; margin:10px 0px 2px 0px; padding:2px 0px">
                        Termeni si conditii de calatorie
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:0.6rem">
                        In functie de numarul de pasageri circula microbus/autocar.Rezervarea este valabila numai cu confirmarea agentiei transportatoare.
                        <br>
                        <b>Conditii generale de calatorie:</b> Rezervarile on-line trebuie facute cu cel putin 24 ore inaintea plecarii. In cazul in care datele personale/ datele si orele de calatorie au fost completate gresit pasagerul risca sa isi piarda rezervarea .Este necesar sa va prezentati la locul plecarii cu minim 15 minute inainte de plecarea catre Otopeni.  Orice intarziere, atrage responsabilitatea unilaterala a pasagerului intarziat.
                        <br>
                        <b>Intarzieri / anulari / modificari:</b> Transportatorul va depune toate eforturile pentru a transporta pasagerul intr-un termen rezonabil. Orele indicate pe voucher, in orare si in alte documente nu sunt garantate si nu fac parte din contractul de transport. Transportatorul isi declina orice raspundere pentru intreruperea cursei sau pentru intarzieri datorate conditiilor atmosferice sau timpilor de asteptare in situatiile in care traficul este blocat, restrictionat sau deviat, si (sau) pentru pierderile suferite de catre pasager, ca urmare a acestor intarzieri.Transportatorul isi rezerva dreptul sa anuleze o cursa in cazul unui atac terorist, blocada, greva, conditii meteo nefavorabile, miscari sociale, probleme tehnice ale autocarului (microbuzului) sau alte circumstante ce ar putea constitui un impediment pentru efectuarea calatoriei.
                        <br>
                        <b>Bagaje:</b>Transportatorul nu isi asuma nicio responsabilitate pentru transportul bagajelor. Aceasta revine in intregime pasagerului, in afara cazului in care deteriorarea este din vina transportatorului si poate fi dovedita de pasager. Pasagerii au obligatia sa-si supravegheze bagajele in timpul opririlor, al debarcarii sau al imbarcarilor de pe traseu. Pasagerii au obligatia sa depuna orice reclamatie referitoare la pierderea (furtul) sau deteriorarea bagajelor, imediat dupa sosire. Orice reclamatie ulterioara nu va mai fi luata in considerare.
                        <br>
                        <b>Obligatiile pasagerului:</b> Este interzis pasagerilor: deteriorarea sau murdarirea autocarului (microbuzului), obstructionarea in orice fel a conducatorului auto sau a celorlalte persoane din echipaj in indeplinirea in bune conditii a atributiilor specifice, cauzarea de neplaceri sau disconfort calatorilor din autocar (microbuz) sau altor participanti la trafic. Fumatul, comportamentul inadecvat si consumul bauturilor alcoolice si alimentelor in microbuz sunt strict interzise.
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Transportatorul  isi rezerva dreptul de a refuza transportul sau de a-l intrerupe fara dreptul la o despagubire sau rambursare a pretului biletului , in cazul in care pasagerul nu respecta conditiile de calatorie.

                        {{-- In functie de numarul de pasageri circula microbuz / autocar. Rezervarea este valabila numai cu confirmarea agentiei transportatoare.<br>
                        Detalii Dispecerat: <br>

                        <b>Conditii generale de calatorie:</b><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Rezervarile on-line trebuie facute cu cel putin 24 ore inaintea plecarii pentru a putea fi procesate in timp util.
                        Dupa ce ati efectuat o rezervare on-line va rugam sa verificati daca toate datele si orele de calatorie sunt corecte.
                        In cazul in care datele personale sau datele si orele de calatorie au fost completate gresit pasagerul risca sa isi piarda rezervarea pentru locul din autocar (microbuz).
                        Este necesar sa va prezentati la locul plecarii cu minim 15 minute inainte de plecarea catre Otopeni.
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Orice intarziere, atrage responsabilitatea unilateral a pasagerului intarziat.
                        <br>

                        Intarzieri / anulari / modificari
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        S.C. INTER LEMALIAN SRL va depune toate eforturile pentru a transporta pasagerul si bagajele sale intr-un termen rezonabil.
                        Orele indicate pe voucher, in orare si in alte documente nu sunt garantate si nu fac parte din contractul de transport.
                        S.C. INTER LEMALIAN SRL isi declina orice raspundere pentru intreruperea cursei sau pentru intarzieri datorate conditiilor atmosferice sau timpilor de asteptare in situatiile in care traficul este blocat, restrictionat sau deviat, si (sau) pentru pierderile suferite de catre pasager, ca urmare a acestor intarzieri.
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        S.C. INTER LEMALIAN SRL isi rezerva dreptul sa anuleze o cursa in cazul unui atac terorist, blocada, greva, conditii meteo nefavorabile, miscari sociale, probleme tehnice ale autocarului (microbuzului) sau alte circumstante ce ar putea constitui un impediment pentru efectuarea calatoriei.
                        <br>

                        <b>Bagaje:</b>
                        <br>
                        S.C. INTER LEMALIAN SRL nu isi asuma nici o responsabilitate pentru transportul bagajelor.
                        Aceasta revine in intregime pasagerului, in afara cazului in care deteriorarea este din vina transportatorului si poate fi dovedita de pasager.
                        S.C. INTER LEMALIAN SRL nu este responsabila in cazul pierderii sau deteriorarii de bunuri si obiecte de valoare.
                        Pasagerii au obligatia sa-si supravegheze bagajele in timpul opririlor, al debarcarii sau al imbarcarilor de pe traseu.
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Pasagerii au obligatia sa depuna orice reclamatie referitoare la pierderea (furtul) sau deteriorarea bagajelor, imediat dupa sosire, la echipaje si sa confirme in scris in maxim 48 de ore de la sosire. Orice reclamatie ulterioara nu va mai fi luata in considerare.

                        <b>Obligatiile pasagerului:</b>
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Este interzis pasagerilor: deteriorarea sau murdarirea autocarului (microbuzuluii), obstructionarea in orice fel a conducatorului auto sau a celorlalte persoane din echipaj in indeplinirea in bune conditii a atributiilor specifice, cauzarea de neplaceri sau disconfort calatorilor din autocar (microbuz) sau altor participanti la trafic.
                        Fumatul, comportamentul inadecvat si consumul bauturilor alcoolice si alimentelor in microbuz sunt strict interzise.
                        <br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        S.C. INTER LEMALIAN SRL isi rezerva dreptul de a refuza transportul sau de a-l intrerupe fara dreptul la o despagubire sau rambursare a pretului biletului. --}}

                    </td>
                </tr>
            </table>



    </div>
</body>

</html>
