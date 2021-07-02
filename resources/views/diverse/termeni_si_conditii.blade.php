@extends('layouts.app')

@section('content')
<div class="container p-0">
<div class="row justify-content-center">
    <div class="card col-lg-12 p-0 mb-4 ">
        <div class="d-flex justify-content-between card-header text-white border border-dark" style="background-color:#2C7996;">
            <div class="flex flex-vertical-center">
                <h3 class="mt-2">
                    {{-- <a href="/rezervari"><i class="fas fa-file-alt mr-1"></i>Rezervări</a> - Adaugă o rezervare nouă --}}
                    Termeni și condiții
                </h3>
            </div>
            <div>
                {{-- <a class="btn btn-secondary" href="/rezervari" role="button">Renunță</a> --}}
                <h3 class="mt-2">
                    Zuzu Transfer Airport
                </h3>
            </div>
        </div>

        @include ('errors')

        <div class="card-body px-4 py-3 m-0 pb-0 border border-dark shadow-lg" style="background-color:#EF9A3E;">
            <div class="row mb-3 bg-white">

                <div class="col-lg-12 px-0" style="border:15px #2C7996 solid; ">
                    <h1 class="text-white text-center py-1" style="background-color:#2C7996;">CONDIŢII GENERALE DE TRANSPORT PERSOANE</h1>
                        <div class="p-2 mb-4">
                            <p>ZUZULICA TRANS SRL, având sediul social in Str. Vrancei 20D, Focșani, înregistrată la Registrul Comerțului sub nr. J39/603/2020, având CUI 43014220, oferă servicii de transport persoane în următoarele condiții:</p>

                            <ol>
                                <li><strong>Prezentele Conditii Generale de Transport</strong><strong> sunt parte integranta a contractului de transport incheiat odata cu cumpararea biletului de calatorie.</strong></li>
                                <li>Rezervarea locului nu include obligaţia efectuării transportului de către transportator, această obligaţie intră în vigoare numai după achitarea integrală a biletului de călătorie. Cumpararea biletului de calatorie confirma insusirea si recunoasterea de catre calator a Conditiilor Generale de Transport.</li>
                                <li>La momentul rezervarii locului calatorul trebuie sa indice:
                                    <ul>
                                        <li>Numele si prenumele</li>
                                        <li>Un numar de telefon sau adresa de email la care poate fi contactat.</li>
                                        <li>Data plecării(eventual şi data  întoarcerii)</li>
                                        <li>Locul de plecare şi locul de destinaţie.</li>
                                    </ul>
                                </li>
                                <li>Locurile se atribuie in ordinea solicitarilor.</li>
                                <li>Biletul de calatorie este nominal, nu este transmisibil si trebuie sa fie prezentat personalului de serviciu al firmei ZUZULICA TRANS SRL sau organelor de control autorizate cu verificarea.</li>
                                <li>Biletele de calatorie au o durata de valabilitate de 3 luni de la data emiterii.</li>
                                <li>Biletele pierdute, distruse sau furate se pot inlocui, prin emiterea de catre ZUZULICA TRANS SRL a unui duplicat.</li>
                                <li>La cumparare, pasagerul trebuie sa verifice corectitudinea datelor de calatorie si de identitate inscrise pe bilet si sa solicite pe loc corectarea, in cazul unei neconformitati. Transportatorul nu raspunde pentru erorile descoperite la imbarcare si poate refuza imbarcarea.</li>
                                <li>Prezentarea documentului de identitate valabil este absolut obligatorie pentru imbarcare, in caz contrar firma isi rezerva dreptul de a refuza imbarcarea.</li>
                                <li>Copiii cu varsta mai mica de 12 ani vor fi transportati numai daca sunt insotiti, si beneficiaza de reduceri, astfel: Pretul biletului este cel stabilit de tariful in vigoare, la data eliberarii si poate fi achitat in moneda LEI, la cursul BNR, din ziua efectuarii platii</li>
                                <li>
                                    Tarife:
                                    @php
                                        $tarife = \App\Cursa::with('oras_plecare', 'oras_sosire')
                                                ->whereNotIn('plecare_id', [8,12,13]) // fara plecarile din aeroportul Otopeni (8), sau Vaslui (12), sau Barlad (13)
                                                ->orderBy('durata')
                                                ->get();
                                        // dd($tarife);
                                    @endphp
                                    <table class="table table-striped table-hover text-center">
                                        <thead>
                                            <th  scope="col" colspan="2">
                                                Traseu
                                            </th>
                                            <th scope="col">
                                                Preț adult
                                            </th>
                                            <th scope="col">
                                                Preț copil (2-7 ani)
                                            </th>
                                        </thead>
                                        @forelse($tarife as $tarif)
                                        <tr>
                                            <td>
                                                {{ $tarif->oras_plecare->nume }}
                                            </td>
                                            <td>
                                                {{ $tarif->oras_sosire->nume }}
                                            </td>
                                            <td>
                                                {{ $tarif->pret_adult }}
                                            </td>
                                            <td>
                                                {{ $tarif->pret_copil }}
                                            </td>
                                        </tr>
                                        @empty
                                            *Tarifele nu pot fi afișate din baza de date
                                        @endforelse
                                    </table>
                                </li>
                                <li>Biletele de calatorie se pot plati astfel:
                                    <ul>
                                    <li>Direct la sofer, la urcarea in mijlocul de transport.</li>
                                    <li>In momentul rezervarii biletului pe site-ul <a href="https://rezervari.zuzu-transfer-airport.ro/">ZUZULICA TRANS SRL</a>, prin plata cu cardul. Procesul este securizat și se realizează prin intermediul procesatorului de plăți Netopia Mobilpay  <img src="{{ asset('images/netopia_banner_blue.jpg') }}" class="border border-2 border-black" width="350px"> , <span style="font-size: 16px;">fiind similar cu orice plată din site-urile de comerț electronic.</span></li>
                                    </ul>
                                </li>
                                <li>In pretul biletului este inclus bagajul de mana.</li>
                                <li>Sunt interzise la trasport obiectele care pot produce vatamarea pasagerilor, materiale inflamabile, explozivi, materii radioactive, otravitoare, rau mirositoare, arme de foc si obiecte ascutite, stupefiante, droguri si altele care sunt interzise de autoritatile vamale ale fiecarei tari de destinatie sau tranzitate.</li>
                                <li>Transportatorul nu isi asuma nicio raspundere cu privire la continutul si cantitatea bagajelor, inclusiv raspunderea vamala. Calatorul este obligat sa respecte legislatia in vigoare cu privire la acest lucru.</li>
                                <li>Nu se admit la transport animale.</li>
                                <li>In cazul in care bagajele unuia sau mai multor calatori contin lucruri pentru vamuirea carora este necesara retinerea autocarului (microbuzului) mai mult de 30 minute, bagajele vor fi coborate din autocar (microbuz) impreuna cu detinatorii acestora, autocarul (microbuzul) si restul calatorilor continuandu-si traseul conform graficului de calatorie.</li>
                                <li>Pentru bagajul care contine bunuri personale sau obiecte a caror valoare depaseste 200 Euro (sau echivalent), calatorul este obligat ca la imbarcare sa le declare, sub forma unei declaratii scrise care se preda conducatorului auto.<strong> </strong>Pentru aceste bagaje se percep taxe suplimentare.</li>
                                <li>Deteriorarea sau disparitia unui bagaj din cala autocarului (microbuzului), va fi consemnata imediat dupa coborarea din autocar (microbuz) in biletul de calatorie, de catre conducatorul auto. Sesizarea disparitiei se va face la sediul firmei de transport, in termen de trei zile da la data  calatoriei  aceasta fiind insotita de copia  biletului de calatorie si a tichetului de bagaj.</li>
                                <li>Este interzis transportul în bagajul de cală : bijuterii, bani, camere foto, laptopuri, notebook, telefone mobile, sau orice tip de aparate electrice alimentate de baterii.</li>
                                <li>Răspunderea transportatorului pentru bagajele călătorilor care călătoresc cu autocarele (microbuzele) si pe distanţe naţionale internaţionale poate fi angajată pentru furtul, pierderea sau deteriorarea bagajelor transportate în cala de bagaje, altele decât bagajele de mînă numai în cazul în care acestea se produc din vina echipajului autocarului (microbuzului), vina care trebuie dovedită de călător, sub rezerva depunerii reclamaţiei.</li>
                                <li>Transportatorul nu poate fi responsabil pentru dispariţia sau deteriorarea bagajelor de mînă transportate în salonul autocarului (microbuzului), decât atunci când aceasta a intervenit ca urmare a vinei dovedite a transportatorului.</li>
                                <li>Pentru evitarea situaţiilor în care răspunderea transportatorului nu poate fi angajată, se recomandă încheierea unei asigurări pentru bagaje.</li>
                                <li>In cazul daunelor privind bagajele care se transporta în cala autocarului (microbuzului), transportatorul acorda despagubiri in limita sumei de 100 Euro/bagaj si de maxim 200 Euro de calator, numai după îndeplinirea condiţiilor de la pct. 20. In lipsa acestor documente nu se acorda despagubiri.</li>
                                <li>Responsabilitatea transportatorului se limiteaza la durata transportului. In ceea ce priveste bagajele si obiectele nedeclarate transportatorului, acesta din urma nu este responsabil de pierderea sau deteriorarea acestora, cu exceptia cazurilor in care pasagerul demonstreaza ca acestea au fost cauzate din motive imputabile transportatorului.</li>
                                <li>In autocar(microbuz), in statiile de oprire, calatorul trebuie sa respecte indicatiile personalului angajat al transportatorului.</li>
                                <li>Pe parcursul deplasarii, calatorul va pastra asupra lui, la indemana, biletul in original si documentul de indentitate.</li>
                                <li>Calatorul trebuie sa aiba un comportament care sa nu-i afecteze pe ceilalti calatori asigurind astfel desfasurarea in conditii normale a transportului. De asemenea, calatorul trebuie sa se prezinte intr-o stare de igiena corporala adecvata calatoriei.</li>
                                <li>Transportatorul nu este raspunzator pentru nici o dauna rezultata din nerespectarea oricaror legi aplicabile, regulamente, ordine, cereri sau cerinte impuse de un organism guvernamental.</li>
                                <li>Transportatorul are dreptul de a refuza preluarea la transport sau de a intrerupe calatoria pasagerului, fara a-i returna pretul biletului si fara drept de despagubire ulterioara in cazul in care constata ca acesta este: in stare de ebrietate, sub influenţa narcoticelor sau într-o stare care indica prezenta unei boli contagioase, are un comportament necorespunzator fata de ceilalti calatori, de reprezentantii societatii, sau ai autoritatilor, sau incalca flagrant conditiile contractului de transport. De asemenea, daunele produse de calatori autocarului(microbuzului), vor fi penalizate.</li>
                                <li>In cazul intreruperii transportului din vina calatorului, biletul de calatorie isi pierde valabilitatea, iar valoarea calatoriei  nu se returneaza.</li>
                                <li>Transportatorul isi declina orice raspundere pentru intreruperea cursei sau pentru intarzieri datorate conditiilor atmosferice sau traficului rutier.</li>
                                <li>Transportatorul are dreptul, oricand, sa anuleze o cursa in cazul amenintarii sau existentei unui razboi, conflict armat, atac terorist, blocada, greva, conditii meteorologice nefavorabile, miscari sociale sau alte circumstante ce ar putea fi un impediment pentru efectuarea calatoriei.</li>
                                <li>Nici o plecare in cursa nu poate fi amânata (intarziata) din cauza intarzierii calatorilor.</li>
                                <li>Călătorul poate renunța parțial sau total la călătorie. Transportatul acordă restituirea costului biletului în cazul renunțării totale sau parțiale la călătorie, cu condiția ca renunțarea să se facă cu cel puțin două zile înainte de data plecării.</li>
                                <li>Data plecării poate fi modificată la cererea călătorului, cu condiția să fie cu cel puțin două zile înainte de data inițială a plecării;</li>
                                <li>În cazul în care prețul biletului inițial este mai mare decât prețul biletului stabilit în urma reprogramării călătoriei, călătorul este îndreptățit la rambursarea diferenței de preț.</li>
                                <li>În cazul în care prețul biletului inițial este mai mic decât prețul biletului stabilit în urma reprogramării călătoriei, călătorul este obligat la plata diferenței de preț.</li>
                                <li>Orice restituire se acorda numai titularului de bilet.</li>
                                <li>Fumatul în autocar (microbuz) sau în apropierea acestuia este strict interzis. Fumatul este permis numai în locuri special amenajate.</li>
                                <li>Eventualele sesizari ale calatorilor privind desfasurarea transportului, sub toate aspectele, se transmit direct către Iulian Lemnaru prin email <a href="mailto:rezervari@zuzu-transfer-airport.ro">rezervari@zuzu-transfer-airport.ro</a> sau la telefon <a href="tel:+40768112244"> +40 768 112 244</a>, in termen de 3 zile de la data incheierii calatoriei. Reclamatiile transmise dupa acest termen nu se iau in considerare.</li>
                                <li>In caz de litigiu, calatorul nu poate invoca necunoasterea clauzelor contractului de transport (bilet de calatorie, conditii generale de transport).</li>
                                <li>Prezentele condiții generale privind furnizarea serviciilor poștale sunt valabile începând cu data de 01.01.2021.</li>
                            </ol>
                        </div>
                        <a name="politica-de-confidentialitate"></a>

                    <h1 class="text-white text-center py-1 pt-4" style="background-color:#2C7996;">POLITICA DE CONFIDENTIALITATE</h1>
                        <div class="p-2 mb-4">
                            <p>ZUZULICA TRANS SRL, având sediul social in Str. Vrancei 20D, Focșani, înregistrată la Registrul Comerțului sub nr. J39/603/2020, având CUI 43014220, prelucrează date cu caracter personal.</p>
                            <p>Datele cu caracter personal vor fi colectate si prelucrate de către ZUZULICA TRANS SRL numai in măsura permisa prin Regulamentul General (UE) 2016/679 privind protecția persoanelor fizice în ceea ce privește prelucrarea datelor cu caracter personal și privind libera circulație a acestor date (GDPR).</p>
                            <p>Termeni in înțelesul Regulamentului General (UE) 2016/679:</p>
                            <ul>
                                <li>„date cu caracter personal” înseamnă orice informații privind o persoană fizică identificată sau identificabilă („persoana vizată”); o persoană fizică identificabilă este o persoană care poate fi identificată, direct sau indirect, în special prin referire la un element de identificare, cum ar fi un nume, un număr de identificare, date de localizare, un identificator online, sau la unul sau mai multe elemente specifice, proprii identității sale fizice, fiziologice, genetice, psihice, economice, culturale sau sociale;</li>
                                <li>„prelucrare” înseamnă orice operațiune sau set de operațiuni efectuate asupra datelor cu caracter personal sau asupra seturilor de date cu caracter personal, cu sau fără utilizarea de mijloace automatizate, cum ar fi colectarea, înregistrarea, organizarea, structurarea, stocarea, adaptarea sau modificarea, extragerea, consultarea, utilizarea, divulgarea prin transmitere, diseminarea sau punerea la dispoziție în orice alt mod, alinierea sau combinarea, restricționarea, ștergerea sau distrugerea;</li>
                                <li>„restricționarea prelucrării” înseamnă marcarea datelor cu caracter personal stocate cu scopul de a limita prelucrarea viitoare a acestora;</li>
                                <li>„operator” înseamnă persoana fizică sau juridică, autoritatea publică, agenția sau alt organism care, singur sau împreună cu altele, stabilește scopurile și mijloacele de prelucrare a datelor cu caracter personal; atunci când scopurile și mijloacele prelucrării sunt stabilite prin dreptul Uniunii sau dreptul intern, operatorul sau criteriile specifice pentru desemnarea acestuia pot fi prevăzute în dreptul Uniunii sau în dreptul intern;</li>
                                <li>„persoană împuternicită de operator” înseamnă persoana fizică sau juridică, autoritatea publică, agenția sau alt organism care prelucrează datele cu caracter personal în numele operatorului;„parte terță” înseamnă o persoană fizică sau juridică, autoritate publică, agenție sau organism altul decât persoana vizată, operatorul, persoana împuternicită de operator și persoanele care, sub directa autoritate a operatorului sau a persoanei împuternicite de operator, sunt autorizate să prelucreze date cu caracter personal;</li>
                                <li>„consimțământ” al persoanei vizate înseamnă orice manifestare de voință liberă, specifică, informată și lipsită de ambiguitate a persoanei vizate prin care aceasta acceptă, printr-o declarație sau printr-o acțiune fără echivoc, ca datele cu caracter personal care o privesc să fie prelucrate;</li>
                            </ul>
                            <p>ZUZULICA TRANS SRL, prelucrează datele personale colectate în temeiul încheierii și executării contractelor cu clienții, în vederea realizării intereselor legitime în relație cu scopurile menționate mai sus și în alte situații în temeiul consimțământului clienților. Scopurile colectării datelor sunt: informarea utilizatorilor/clienților (cumpărătorilor) privind situația contului lor,informarea utilizatorilor/clienților privind evoluția si starea comenzilor, evaluarea produselor si serviciilor oferite, activități comerciale, de promovare a produselor si serviciilor, de marketing, de publicitate, de media, administrative, de dezvoltare, de cercetare de piață, de statistică, de urmărire și monitorizare a vânzărilor și comportamentului consumatorilor.</p>
                            <p>Prelucrarea datelor cu caracter personal se face atat in regim propriu cat si utilizând produsele oferite de <a href="https://validsoftware.ro/" target="_blank" rel="noopener">validsoftware.ro</a>, care este furnizorul nostru de servicii web (găzduire website, realizare și administrare pagină web, promovare online și consultanță IT). validsoftware.ro asigură confidențialitatea datelor găzduite, iar politica de confidențialitate poate fi accesată aici – <a href="https://validsoftware.ro/politica-de-confidentialitate/" target="_blank" rel="noopener">https://validsoftware.ro/politica-de-confidentialitate/</a>.</p>
                            <p>Partenerii sunt atent selectați și se obligă să asigure, prin măsuri tehnice și organizatorice adecvate, prelucrarea datelor dumneavoastră conform prevederilor legale în vigoare privind protecția datelor și cu respectarea drepturilor dumneavoastră. Partenerilor le este interzis să utilizeze datele cu caracter personal primite pentru scopuri proprii sau comerciale sau să le transmită terților, cu excepția cazului în care terții acționează pentru atingerea scopurilor prelucrării descrise prin prezenta, caz în care aceleași condiții privind măsurile tehnice și organizatorice se aplica și acestora.</p>
                            <p>Prin citirea prezentei Politici de protecția datelor cu caracter personal și a Notei de Informare ați luat la cunoștință faptul că vă sunt garantate drepturile prevăzute de GDPR, respectiv:</p>
                            <ul>
                                <li>dreptul la transparența informațiilor, a comunicărilor și a modalităților de exercitare a drepturilor dvs.;</li>
                                <li>dreptul la informare și acces la datele dvs. cu caracter personal, – dreptul la rectificare si dreptul la ștergerea datelor;</li>
                                <li>dreptul la restricționarea prelucrării;</li>
                                <li>dreptul la portabilitatea datelor</li>
                                <li>dreptul la opoziție și de a nu fi supus unui procesul decizional individual automatizat</li>
                                <li>dreptul de a vă adresa Autorității de Supraveghere (ANSPDCP) în caz de încălcare a drepturilor dvs. garantate de legislația privind protecția datelor cu caracter personal.</li>
                            </ul>
                            <p>Pentru exercitarea drepturilor mai sus menționate sau pentru orice întrebare legată de modul în care datele dumneavoastră sunt utilizate ori dacă unele dintre datele despre dumneavoastră sunt incorecte, vă puteți adresa cu o cerere scrisă, datată și semnată către ZUZULICA TRANS SRL, Str. Vrancei 20D, Focșani, în atenția responsabilului cu protecția datelor, sau la adresa de email <a href="mailto:rezervari@zuzu-transfer-airport.ro">rezervari@zuzu-transfer-airport.ro</a></p>
                            <p>În cerere, vă rugăm să menționați dacă doriți ca informațiile să fie comunicate la o anumită adresă (poștală sau e-mail) sau printr-un serviciu de curierat care să asigure că veți primi personal informațiile. Va rugam sa țineți cont ca, înainte de a da curs oricărei astfel de cereri, ne rezervam dreptul de a va verifica identitatea, pentru a ne asigura ca solicitarea provine chiar din partea dumneavoastră. De asemenea, va este recunoscut dreptul de a va adresa justiției pentru orice încălcare a drepturilor dumneavoastră privind prelucrarea datelor cu caracter personal. Informațiile pe care ni le furnizați vor fi utilizate și stocate doar în scopul pentru care le-ați furnizat, pentru a administra, a sprijini și a evalua serviciile noastre, inclusiv pentru a preîntâmpina încălcarea securității sistemelor, și pentru respectarea legii și a termenilor noștri contractuali. În acest sens, ZUZULICA TRANS SRL va stoca datele dvs. în conformitate cu Politica de Retenție a Datelor care reglementează termene – limită prestabilite și bine documentate pentru diferite categorii de date cu caracter personal, în funcție de specificul operațiunilor pentru care sunt necesare. Mai mult, ZUZULICA TRANS SRL se asigură că datele cu caracter personal sunt adecvate, relevante și limitate la ceea ce este necesar pentru scopurile în care sunt prelucrate si de asemenea, se asigură că perioada pentru care datele cu caracter personal sunt stocate este limitată, iar la împlinirea termenelor limită, datele personale nu vor mai fi prelucrate în aceste scopuri.</p>
                            <p>ZUZULICA TRANS SRL poate furniza datele dumneavoastră cu caracter personal altor companii cu care se află în relații de parteneriat, dar numai în temeiul unui angajament de confidențialitate din partea acestora, prin care garantează că aceste date sunt păstrate în siguranță și că furnizarea acestor informații personale se face conform legislației în vigoare, după cum urmează: furnizori de servicii de curierat, servicii de bancare, alte companii cu care putem dezvolta programe comune de ofertare pe piață a produselor și serviciilor noastre, imputerniciti ai ZUZULICA TRANS SRL ce actioneaza in limitele si scopurile stabilite de ZUZULICA TRANS SRL, conform conditiilor din prezenta Politica.</p>
                        </div>

                    <h1 class="text-white text-center py-1 pt-4" style="background-color:#2C7996;">TERMENI SI CONDITII DE UTILIZARE A SITEULUI</h1>
                        <div class="p-2 mb-4">
                            <p><b>1. Definiții</b></p>
                            <p>1.1. În cuprinsul prezentului document, următorii termeni folosiți cu majuscule vor avea, dacă din context nu rezultă altfel, înțelesurile specificate mai jos:</p>
                            <p>SITE: reprezintă SITE-ul Internet aparținând ZUZULICA TRANS SRL, care se află la adresa https://zuzu-transfer-airport.ro/, prin intermediul căruia UTILIZATORUL are acces la informații privind serviciile și produsele oferite / asigurate de către ZUZULICA TRANS SRL.</p>
                            <p>ZUZULICA TRANS SRL: reprezintă societatea ZUZULICA TRANS SRL, cu sediul sediul social in Str. Vrancei 20D, Focșani, înregistrată la Registrul Comerțului sub nr. J39/603/2020, având CUI 43014220.</p>
                            <p>UTILIZATOR: reprezintă persoana care accesează SITE-ul, în scopuri private sau profesionale și care a acceptat TERMENII ȘI CONDIȚIILE prezentului SITE.</p>
                            <p>UTILIZARE ABUZIVA: reprezintă utilizarea SITE-ului într-un mod contrar practicii în domeniu, a reglementarilor și ale legislației în vigoare sau în orice alt mod care poate produce prejudicii ZUZULICA TRANS SRL.</p>
                            <p><b>2. Conținutul site-ului</b></p>
                            <p>2.1. Informațiile publicate pe SITE sunt informații de interes general despre ZUZULICA TRANS SRL, produsele comercializate de acesta, ale partenerilor săi cât și alte informații considerate de ZUZULICA TRANS SRL ca fiind de interes pentru UTILIZATORI.</p>
                            <p>2.2. Informațiile sunt puse la dispoziția UTILIZATORILOR de regula, în mod gratuit. ZUZULICA TRANS SRL își rezervă dreptul de a implementa anumite servicii pe SITE ce vor fi oferite contra cost UTILIZATORILOR.</p>
                            <p>2.3. ZUZULICA TRANS SRL este deținătorul tuturor drepturilor de proprietate intelectuala asupra SITE-ului, respectiv asupra designului și conținutului acestuia. UTILIZATORUL are obligația de a respecta toate drepturile de proprietate intelectuală ale ZUZULICA TRANS SRL, prevăzute de legislația în vigoare.</p>
                            <p><b>3. Utilizarea site-ului</b></p>
                            <p>3.1. UTILIZATORUL se obligă sa acceseze și să utilizeze SITE-ul în scopuri și prin mijloace care să nu constituie o utilizare abuzivă.</p>
                            <p><b>4. Limitarea răspunderii ZUZULICA TRANS SRL</b></p>
                            <p>4.1. Răspunderea pentru conținutul SITE-ului.</p>
                            <p>ZUZULICA TRANS SRL nu este și nu poate fi făcut responsabil pentru prejudiciile create de erorile, neacuratețea sau neactualizarea informațiilor publicate sau menținute pe SITE, care nu se datorează culpei sale.</p>
                            <p>4.2. În cazul în care prețurile sau alte detalii referitoare la produse/promoții au fost afișate greșit, inclusiv din cauza faptului ca au fost introduse greșit în baza de date, ne alocăm dreptul de a anula livrarea respectivului produs și de a anunța clientul telefonic/e-mail în cel mai scurt timp, despre eroarea apărută, dacă produsul nu s-a livrat încă.</p>
                            <p>4.3. Caracteristicile produselor prezentate pe SITE sunt preluate / puse la dispoziție de producători și/ furnizori și ZUZULICA TRANS SRL nu își asuma răspunderea pentru corectitudinea acestor informații.</p>
                            <p>4.4. Preturile produselor de pe acest SITE sunt informative și pot suferi modificări neanunțate. Promoțiile prezentate pe SITE sunt valabile în perioada de timp menționată. În cazul în care nu se menționează o perioadă de timp, acestea sunt valabile în limita stocurilor disponibile.</p>
                            <p>4.5. De asemenea, imaginile sunt prezentate pe SITE cu titlu de exemplu, iar produsele livrate, pot diferi de imagini în orice mod, datorită modificării caracteristicilor, și/sau a design-ului fără notificare prealabilă de către producători.</p>
                            <p>4.6. ZUZULICA TRANS SRL își rezerva dreptul sa completeze și sa modifice orice informație de pe SITE.</p>
                            <p>4.7. Orice problema cauzata de produsele și / serviciile prezentate pe SITE se va soluționa pe cale amiabila în termen de 15 zile lucrătoare de la data sesizării în scris a problemelor, de către UTILIZATOR.</p>
                            <p>4.8. ZUZULICA TRANS SRL nu răspunde de nici o pierdere, costuri, procese, pretenții, cheltuieli sau alte răspunderi, în cazul în care acestea sunt cauzate direct de nerespectarea Termenilor și condițiilor. ZUZULICA TRANS SRL nu răspunde pentru prejudiciile create ca urmare a nefuncționării Site-ului precum și pentru cele rezultând din imposibilitatea de accesare a anumitor link-uri publicate pe Site.</p>
                            <p><b>5. Utilizarea Browser-ului Internet.</b></p>
                            <p>ZUZULICA TRANS SRL garantează utilizarea optima a Site-ului prin utilizarea ultimelor versiuni de browser Chrome, Firefox si Safari.</p>
                            <p><b>6. Accesarea SITE-ului</b></p>
                            <p>Aceasta implică acceptul UTILIZATORILOR ca datele lor personale sa fie păstrate și prelucrate de ZUZULICA TRANS SRL. Scopurile prelucrării acestor date sunt: crearea unei baze de date pentru realizarea de rapoarte statistice, informarea despre promoțiile rețelei de magazine ZUZULICA TRANS SRL sau despre orice alte promoții sau activități desfășurate de ZUZULICA TRANS SRL prin orice mijloace de comunicare (posta, e-mail, telefon, SMS, etc.). ZUZULICA TRANS SRL este unicul deținător al informațiilor colectate de pe acest site. ZUZULICA TRANS SRL se obligă ca datele personale sa nu fie difuzate către terți prin vânzare, dezvăluire parțială, sau închiriere.</p>
                            <p><b>7. Colectarea datelor</b></p>
                            <p>Se face prin diverse modalități și instrumente specifice precum: soft profesional de urmărire a traficului, aplicația de gestiune a newsletter-ului, prin salvarea în baze de date a formularului de contact disponibil pe site care este completat de către utilizatori, prin chestionare online etc. Utilizam adresele IP pentru a analiza obiceiurile de navigare, a administra site-ul, a urmări interesele utilizatorilor și a aduna informații demografice pentru uz intern. Toate acestea au ca scop creșterea gradului de ușurința în utilizarea site-ului și publicarea unor informații cat mai relevante pentru interesele utilizatorilor.</p>
                            <p><b>8. Acces restricționat și (dez)abonare</b></p>
                            <p>Exista zone în site care necesita Conectare sau abonare (vezi newsletter). În cazul newsletter-ului, fiecare ediție/alertă conține și modalitatea de dezabonare; odată accesată aceasta opțiune, dezabonarea se aplică imediat, nefiind necesare alte confirmări din partea utilizatorilor. În funcție de tipul de înregistrare (creare cont site, abonare newsletter), utilizatorului îi pot fi solicitate date precum: nume, prenume, email, adresa, etc. Aceste date sunt folosite pentru identificare, validarea sau completarea contului de abonat.</p>
                            <p><b>9. Cookies</b></p>
                            <p>Site-ul folosește cookie-uri, acestea fiind date stocate pe computerul, terminalul mobil sau alt echipament al utilizatorului, conținând informații despre acesta. Folosirea mecanismului de tip cookie reprezintă un avantaj în folosul vizitatorilor, acesta permițând memorarea unor opțiuni de navigare în site precum limba în care se afișează site-ul, tip de filtre care se aplică la afișarea unor anumite pagini, memorarea numelui de utilizator și a parolei pentru un acces rapid la conținutul site-ului. Neacceptarea unui cookie nu înseamnă că utilizatorului îi va fi refuzat accesul de navigare în site, sau de citire a conținutului acestuia. Cu ajutorul cookies, proprietarii de site-uri pot monitoriza și segmenta interesele utilizatorilor față de anumite zone sau aplicații ale site-ului, fapt care le permite ulterior îmbunătățirea experienței de navigare, introducerea unui conținut relevant pentru utilizator etc.</p>
                            <p>Cookies care, din punct de vedere tehnic, nu sunt obligatorii a fi stocate pe terminalul utilizatorului, vor fi folosite doar dacă utilizatorul își exprimă consimțămantul expres și neechivoc în legatură cu acestea, prin bifarea categoriilor prezentate. Utilizatorul își va putea retrage consimțămantul în orice moment prin modificarea setărilor aferente browser-ului utilizat, în conformitate cu Politica noastra de Cookies .</p>
                            <p><b>10. Link-urile</b></p>
                            <p>Acest site conține link-uri către alte site-uri. ZUZULICA TRANS SRL nu este responsabil de politica de confidențialitate practicată de aceștia. Vă recomandăm consultarea în prealabil a termenilor legali și a celorlalte informații referitoare la colectarea datelor cu caracter personal. Normele expuse în acest text se aplica doar în cazul datelor colectate pe acest site.</p>
                            <p><b>11. Notificări și acțiuni privind informațiile despre utilizatori</b></p>
                            <p>La cererea scrisă a utilizatorilor, datată și semnată, expediată pe adresa ZUZULICA TRANS SRL, acesta se obligă:</p>
                            <p>să confirme solicitanților, dacă prelucrează sau nu date personale; acest lucru se face gratuit, o singură dată pe an; să rectifice, actualizeze, blocheze, șteargă sau să transforme în date anonime, în mod gratuit, datele a căror prelucrare nu este conformă dispozițiilor privind protecția persoanelor cu privire la prelucrarea datelor cu caracter personal și libera circulație a acestor date; să transmită utilizatorului datele cu caracter personal care o privesc și pe care le-a furnizat ZUZULICA TRANS SRL într-un format structurat, utilizat în mod curent și care poate fi citit automat în vederea transmiterii acestora altui operator; să înceteze prelucrarea datelor personale ale utilizatorului, dacă acesta solicită acest lucru.</p>
                            <p><b>12. Comunicarea modificărilor</b></p>
                            <p>Dacă informațiile de identificare ale unui utilizator se schimbă (ca de exemplu codul poștal) sau dacă un utilizator dorește să renunțe la serviciile noastre, vom avea grija sa corectăm, actualizăm sau să eliminăm acele date personale care ne-au fost încredințate de către utilizator. Acest lucru poate fi realizat fie de pe pagina de înregistrare, fie prin intermediul formularului de contact de pe SITE.</p>
                            <p>Orice schimbare a termenilor prezentei politici va fi comunicată către utilizatori prin email, astfel încât aceștia să fie întotdeauna informați cu privire la datele pe care le colectăm, cum le utilizăm și în ce circumstanțe. Utilizatorii vor putea să fie sau nu de acord cu utilizarea informațiilor în alte scopuri. Vom utiliza datele în concordanță cu politica sub care au fost culese informațiile, conform cu Nota de informare privind prelucrarea datelor, precum și cu Politica privind protectia datelor cu caracter personal .</p>
                            <p><b>13. Securitate</b></p>
                            <p>Acest site adoptă toate măsurile de securitate necesare protejării datelor personale ale utilizatorilor noștri. În momentul completării datelor personale pe site-ul nostru, informațiile vor fi protejate atât offline cât și online. Toate datele cu caracter personal vor fi prelucrate prin intermediul unor pagini securizate care folosesc sistemul de criptare SSL.</p>
                            <p>Fiind de acord cu prezentul document „Termeni si condiții de utilizare a site-ului”, utilizatorii își asuma în totalitate eventualele riscuri.</p>
                        </div>

                    {{-- <h1 class="text-white text-center py-1 pt-4" style="background-color:#2C7996;">COLETE</h1>
                        <div class="p-2 mb-4">
                            <ol>
                                <li>Coletele voluminoase și ușoare se taxează la volum. Volumul se calculează astfel: L x 1 x H (cm)/6000 = kg volumetric (1 m3 = 166kg)</li>
                                <li>La coletele cu valoare declarată se încasează un comision de 5% din valoarea declarată.</li>
                                <li>Verificați coletele și conținutul acestora în momentul primirii. Orice reclamație ulterioară nu va fi luată în considerație.</li>
                                <li>Nu răspundem de coletele a căror conținut este perisabil ori fragil.</li>
                                <li>Nu răspundem de coletele a căror distrugere este cauzată de conținutul acestora sau de modul în care au fost ambalate.</li>
                                <li>Nu sunt admise la transport: materiale explozibile, muniție, artificii, materiale inflamabile, gaze comprimate (ex: butan, propan, oxigen), lichide inflamabile (ex: benzină, acetonă) și toate celelalte articole menționate ca interzise prin legislația în vigoare. De asemenea nu transportăm țigări sau țuică de cazan.</li>
                                <li>Nu introduceți în colete bani, aur, argint, pietre prețioase sau alte obiecte de valoare. Obiectele de valoare vor fi împachetate în prezența transportatorului.</li>
                                <li><strong>Coletele se vor prezenta desfăcute și se vor sigila în prezența agentului care le preia.</strong></li>
                                <li><strong>Ne rezervăm dreptul de a verifica conținutul coletului!</strong></li>
                                <li><strong>Tarif minim 20euro/colet până în 15kg, excedentul 1,5 &#8211; 2 euro/kg în funcție de destinație.</strong></li>
                            </ol>
                            <p><strong>Sfaturi de împachetare</strong></p>
                            <ul>
                                <li>Alegeți dimensiunea ambalajului în funcție de conținutul acestuia.</li>
                                <li>Luați în seamă rezistența, amortizarea și durabilitatea atunci când selectați ambalajele</li>
                                <li>Alegeți cutii din carton rezistent cu dublu strat</li>
                                <li>Luați în seamă că ambalajul defectuos poate deteriora obiectele din interiorul său</li>
                                <li>Ambalați în mod corespunzător cadourile (bunurile vândute în ambalajele atractive nu sunt potrivite pentru expediere)</li>
                                <li>Discurile cu date, casetele audio sau video vor fi ambalate fiecare în material moale izolat</li>
                                <li>Nu uitați să ambalați obiectele mici în ambalajele corespunzătoare</li>
                                <li>Asigurați-vă că lichidele sunt depozitate în recipiente etanșe.</li>
                            </ul>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
