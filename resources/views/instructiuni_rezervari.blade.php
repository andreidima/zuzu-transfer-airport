@extends ('layouts.app')

@section('content') 

<div class="card">
<div class="card-body rounded px-5 shadow-lg">

<p><em>Pe această pagină gășiți instrucțiunile pt rezervări. Vor fi afișate și noutăți, schimbări de program sau modificări ale site-ului.</em></p>

<p><strong>PENTRU O MAI BUNĂ FUNCȚIONARE A SISTEMULUI VA RUGĂM SĂ FOLOSIȚI MOZILLA SAU CHROME!</strong></p>
{{-- <p>___________________________________</p> --}}

{{-- <p class="text-danger"><b>Program de sarbatori 2019 - 2020:</b></p>

<p class="text-danger">- 24.12.2019 si 31.12.2019 ultima cursa pe tur Galati/Tecuci este la 10:30 iar din Otopeni la ora 14:30,</p>

<p class="text-danger">- 26.12.2019 si 02.01.2020 prima cursa pe tur Galati/Tecuci este la ora 00:00 iar din Otopeni la ora 04:00,</p>

<p class="text-danger">- 25.12.2019 si 01.01.2020 nu se lucreaza.</p> --}}

{{-- <p class="text-danger p-0 my-1"><b>Program de Paște 2020: program normal, se efectuează toate cursele!</b></p> --}}


{{-- <p>___________________________________</p>
<p>Am implementat pe site oferta dus-intors la pretul 100lei/adult (20lei comision agentie), 60lei/copil 2-7ani (10lei comision agentie), pe traseul Galati-Otopeni (aeroport) cu urmatoarele conditii:</p>
<ul style="list-style-type: circle">
    <li>grupuri de minim 5 adulti,</li>
    <li>plata integrala la agentie,</li>
    <li><u>doar pentru aeroport Otopeni</u> (pentru debarcare sau imbarcare din Bucuresti nu se aplica oferta).</li>
</ul>
Oferta apare cand introduceti rezervarea si sunt indeplinite toate conditiile, exista posibilitatea de a inregistra rezervarea si fara a accesa oferta daca nu o doriti.
<br>
Este posibil sa fie nevoie sa incercati de cateva ori refresh la pagina cu CTRL+F5 daca nu va apare oferta.
<br>
*Contravaloarea transportului nu se returneaza.*
<p>___________________________________</p> --}}


<p>Înainte de a face o rezervare asigurați-va că sunteți autentificat cu adresa de e-mail și parolă, la "<b>Adaugă rezervare</b>",</p>
<ul style="list-style-type: circle">
    <li>alegeți orașul de plecare și orașul de sosire,</li>
    <li>selectați ora din grilă,</li>
    <li>alegeți dată doar din calendarul afișat,</li>
    <li>pentru plecările către Otopeni completați <b>ora decolare</b> avion,</li>
    <li>pentru plecările din Otopeni completați <b>de unde este zborul</b> și <b>ora de aterizare</b> (șoferul va sună pasagerul imediat după aterizare să-l îndrume către mașină, în parcarea de jos lângă bariere)</li>
    <li>nume și prenumele,</li>
    <li>telefon, dacă sunt mai multe numere se pune spațiu între ele,</li>
    <li>nr adulți și nr copii (între 2 și 7 ani) dacă este cazul,</li>
    <li>la <b>Stație de îmbarcare</b> completați de unde se face îmbarcarea, dacă este cazul se adaugă și "debarcare/....." dacă este diferită,</li>
</ul>

<ul style="list-style-type: square">
    <li><b>BRĂILA</b>: Plantelor, Penny pe Bz-ului, Catedrala la covrigaria Panda,</li>
    <li><b>IANCA</b>: la Avion.</li>
    <li><b>GALAȚI</b>:  la McDonald`s.</li>
    <li><b>BUZĂU</b>: McDonald`s</li>
    <li><b>FOCȘANI</b>:  la Lidl sau Lukoil în centru,</li>
    <li><b>RÂMNICU SĂRAT</b>:  la Turist-Profi,</li>
    <li><b>TECUCI</b>:  în parcare la Kaufland,</li>
    <li><b>PANCIU</b>: Notar,</li>
    <li><b>ADJUD</b>: Atlantic sau Lukoil,</li>
    <li><b>MĂRĂȘEȘTI</b>: Gara.</li>
    <li><b>VASLUI</b>: Piața Traian, OMV</li>
    <li><b>BÂRLAD</b>: Electrica</li>
</ul>

<ul style="list-style-type: circle">
    <li>selectați <b>nr de persoane</b> (adulți sau copii),</li>
    <li>dacă încasați comisionul în agenție completați suma în căsuța de comision și apoi selectați “<b>Adaugă rezervarea</b>”</li>
    <li>dacă plata se va face la șofer selectați “<b>Adaugă rezervarea</b>” fără să mai bifați/ completați altceva,</li>
    <li>dacă încasați integral la agenție bifați “<b>Plată: La agenție</b>”</li>
    <li>dacă se solicită și retur bifați “<b>Retur</b>”, completați datele de întoarcere și apoi selectați “<b>Adaugă rezervarea</b>”</li>
    <li>verificați datele introduse apoi selectați “<b>Adaugă rezervarea</b>”, rezervarea s-a înregistrat, puteți descarcă biletul.</li>
    <li>Pentru a reveni la pagină principala selectați “<b>Rezervări</b>” din meniul de sus.</li>
</ul>

<p><b>Aveți posibilitatea de a modifică nr. de telefon și stația de îmbarcare după ce ați făcut rezervarea, de la iconiță de editare din dreptul rezervarii.</b></p>
<p><b>Pentru alte modificări, rezervări greșite sau anulări ne puteți contacta telefonic sau pe mail la adresa <a href="mailto:carabus25@yahoo.com">carabus25@yahoo.com.</a></b></p>
<p>În meniul de sus la „<b>Raport</b>” se pot lista rezervările pe un interval de timp pe care îl selectați din calendar.</p>
<ul>
    <li>Orice altă observație (îmbarcare/debarcare, altă ora dacă e cursa specială, etc )  care trebuie adăugată la rezervare și pt care nu există o căsuța de completare să o scrieți la “<b>Stație de îmbarcare</b>. Este la fel de important să scrieți stația de îmbarcare la plecările către Otopeni, sunt cazuri, mai ales în Brăila, când persoanele nu răspund la telefon și șoferul nu știe de unde să le ia.</li>
    <li>Rezervările care va apar evidențiate cu albastru, sunt anulate de către noi pe motiv că nu s-au prezentat sau au fost anulate la cerere de către clienți telefonic.</li>
</ul>
      
<p><b>Noi sunăm persoanele înainte cu o zi pentru a confirmă rezervările pentru plecările spre Otopeni, pentru retur se trimit sms-uri, nu vor fi sunați cei care fac rezervarea cu o zi înainte sau în aceeași zi cu plecarea, scopul este de a verifica datele înregistrate pe rezervare: ora, dată, stație îmbarcare unde de multe ori nu este scrisă.</b></p>
<p><b>Dacă datele rezervarii nu sunt corecte există riscul că acea rezervare să fie nulă. Rezervările sunt și rămân valabile și fără o confirmare dacă acestea sunt introduse corect. </b></p>
 
<p><b>REZERVĂRILE PT A DOUA ZI (aceasta începând cu ora 00:00) SE FAC PÂNĂ LA ORA 20:50, IAR PT ZIUA ÎN CURS SE VOR ANUNȚA TELEFONIC LA DISPECERAT   0767 335 558 / 0748 836 345 PT A VERIFICA DISPONIBILITATEA LOCURILOR!</b></p>

<p>&nbsp;</p>
<table style="border:1px solid black; border-collapse: collapse; text-align:center;" align="center">
    <tr>
        <td class="p-2" style="border:1px solid black;">
            <b>TRASEU</b>
        </td>
        <td class="p-2" style="border:1px solid black;">
            <b>PRET</b>
        </td>
        <td class="p-2" style="border:1px solid black;">
            <b>COMISION AGENTIE</b>
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            TECUCI,  PANCIU,  ADJUD 
            <br>
            ↔ OTOPENI
            <br>
            <br>
            Oferta grupuri dus-intors*
        </td>
        <td class="p-2" style="border:1px solid black;">
            80 lei/adult (40 lei/copil*)
        </td>
        <td class="p-2" style="border:1px solid black;">
            25lei (5 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            MARASESTI ↔ OTOPENI
        </td>
        <td class="p-2" style="border:1px solid black;">
            70 lei/adult (35 lei/copil*)
        </td>
        <td class="p-2" style="border:1px solid black;">
            15 lei (5 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            FOCSANI ↔ OTOPENI
        </td>
        <td class="p-2" style="border:1px solid black;">
            60 lei/adult  (30 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            15 lei (5 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            RM. SARAT ↔ OTOPENI
        </td>
        <td class="p-2" style="border:1px solid black;">
            50 lei/adult  (25 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            10 lei (5 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            BUZAU ↔ OTOPENI
        </td>
        <td class="p-2" style="border:1px solid black;">
             40 lei/adult  (20 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            10 lei   (5 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            GALATI/BRAILA ↔ OTOPENI
            <br>
            <br>
            Oferta grupuri dus-intors
        </td>
        <td class="p-2" style="border:1px solid black;">
             70 lei/adult  (40 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            20 lei (10 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            VASLUI ↔ OTOPENI
            <br>
            <br>
            Oferta grupuri dus-intors
        </td>
        <td class="p-2" style="border:1px solid black;">
             100 lei/adult  (60 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            20 lei (10 lei)
        </td>
    </tr>
    <tr>
        <td class="p-2" style="border:1px solid black;">
            BARLAD ↔ OTOPENI
            <br>
            <br>
            Oferta grupuri dus-intors
        </td>
        <td class="p-2" style="border:1px solid black;">
             90 lei/adult  (50 lei/copil)
        </td>
        <td class="p-2" style="border:1px solid black;">
            20 lei (10 lei)
        </td>
    </tr>
</table>
<p style="">*copil cu vârstă cuprinsă între 2 și 7 ani</p>

<p class="mb-0">**Oferta dus-intors este valabila cu urmatoarele conditii:</p>
<ul>
    <li>rezervare tur-retur,</li>
    <li>grupuri de minim 5 adulti,</li>
    <li>plata integrala la agentie,</li>
    <li>doar pentru aeroport Otopeni (pentru debarcare sau imbarcare din Bucuresti nu se aplica oferta),</li>
    <li>contravaloarea transportului nu se returneaza daca se anuleaza rezervarea.</li>
</ul>
<p>Oferta apare cand introduceti rezervarea si sunt indeplinite toate conditiile, <b>exista posibilitatea de a inregistra rezervarea si fara a accesa oferta</b> daca nu o doriti. </p>

</div>
</div>
@endsection