<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes(['register' => true, 'password.request' => true]);
Auth::routes();

// Rute pentru rezervare facuta de guest
Route::get('/adauga-rezervare-pasul-1', 'RezervareController@adaugaRezervare1');
Route::post('/adauga-rezervare-pasul-1', 'RezervareController@postAdaugaRezervare1');
Route::get('/adauga-rezervare-pasul-2', 'RezervareController@adaugaRezervare2');
Route::post('/adauga-rezervare-pasul-2', 'RezervareController@postAdaugaRezervare2');
Route::get('/adauga-rezervare-pasul-3', 'RezervareController@adaugaRezervare3');
Route::get('/bilet-rezervat', 'RezervareController@pdfexportguest');
// Route::post('/adauga-rezervare-pasul-3', 'RezervareController@postAdaugaRezervare3');

// Extras date cu Axios
Route::get('/orase_ore_rezervari', 'RezervareController@orase_ore_rezervari');

// Plata online
Route::get('/trimitere-catre-plata', 'PlataOnlineController@trimitereCatrePlata')->name('trimitere-catre-plata');
Route::post('/confirmare-plata', 'PlataOnlineController@confirmarePlata')->name('confirmare-plata');

// Termeni si conditii
Route::view('/termeni-si-conditii', 'diverse/termeni_si_conditii');

// Trimitere Cron joburi din Cpanel
Route::any('/cron-jobs/trimitere-automata/{key}', 'CronJobTrimitereController@trimitere')->name('cronjob.trimitere.automata');

Route::group(['middleware' => 'auth'], function () {

    // Route::get('/', 'AcasaController@index')->name('acasa');
    Route::redirect('/', '/rezervari');

    //Rute Rezervari
    Route::patch('/rezervari/activa/{rezervari}', 'RezervareController@update_activa')->name('update_activa');
    Route::get( 'rezervari/{rezervari}/export/{view_type}', 'RezervareController@pdfexport');

    // Rezervari -> Show - cand este salvata o Rezervare cu Retur, se afiseaza informatiile ambelor Rezervari
        Route::get('rezervari/tur_retur/{rezervare_tur}/{rezervare_retur}', 'RezervareController@show_rezervare_tur_retur');

    // Pagina speciala pentru vizualizare rezervare doar dupa modificare
        Route::get('rezervari/{rezervari}/rezervare_modificata', 'RezervareController@show_dupa_modificare');

    // Rutele default
        Route::resource('rezervari', 'RezervareController')->only([
            'index', 'show', 'create', 'edit', 'store', 'update', 'destroy'
        ]);

        Route::resource('rezervari-istoric', 'RezervareIstoricController')->only([
            'index', 'show'
        ]);

    Route::get('agentii/rezervari', 'UserFirmaController@rezervari');
    Route::get('agentii/rezervari/export/{view_type}/{search_data_inceput}/{search_data_sfarsit}', 'UserFirmaController@pdfexport_rezervari_agentie');  // Generare PDF

    Route::view('/instructiuni-rezervari', 'instructiuni_rezervari');

    Route::post('users/loginas', 'UserController@loginAs')->name('loginas');

    Route::group(['middleware' => 'dispecer'], function () {
        Route::resource('/clienti-neseriosi', 'ClientNeseriosController');

        //Ruta pentru cautarea completa pe o zi sau mai multe
        Route::any('/rezervari-raport-zi', 'RezervareRaportZiController@index');

        // Extras date cu Axios pentru rezervari-raport-zi
        Route::get('/orase_ore_zi_rezervari', 'RezervareRaportZiController@orase_ore_zi_rezervari');

        Route::group(['middleware' => 'mass.delete'], function () {
            Route::any('/rezervari/delete/mass-select', 'RezervareController@massSelect');
            Route::any('/rezervari/delete/mass-delete/{search_data_sfarsit}/{deleted_rows_number}', 'RezervareController@massDelete');
        });

        Route::resource('curse', 'CursaController');

        // Rute Trasee
        Route::get('trasee/{trasee}/{data_traseu}', 'TraseuController@show')->name('traseu_dupa_data');    // Generare PDF
        Route::get('trasee/{trasee}/{data_traseu}/export/{view_type}', 'TraseuController@pdfexport');

        // Afisarea rezervarilor pentru un nume de traseu, pe toate orele
        Route::get('trasee/toate_orele/{traseu_nume_id}/{data_traseu}', 'TraseuController@show_toate_orele')->name('traseu_dupa_data_toate_orele');
        Route::get('trasee/toate_orele/{traseu_nume_id}/{data_traseu}/export/{view_type}', 'TraseuController@pdfexport_toate_orele');      // Generare PDF

        //Ruta pentru afisarea retur cu plecarile de la Otopeni
        Route::get('trasee/retur', 'TraseuController@index_retur');

        //Ruta pentru afisarea statisticii Raport/Statistica
        Route::get('statistica', 'TraseuController@index_statistica');

        Route::resource('trasee', 'TraseuController');

        Route::resource('useri', UserController::class,  ['parameters' => ['useri' => 'user']]);

        Route::get('agentii/{agentie}/useri/adauga', 'UserController@create');

        Route::resource('agentii', 'UserFirmaController');
        Route::get('agentii/{agentii}/rezervari', 'UserFirmaController@rezervari');
        Route::get('agentii/{agentii}/rezervari/export/{view_type}/{search_data_inceput}/{search_data_sfarsit}', 'UserFirmaController@pdfexport_rezervari_dispecer');  // Generare PDF

        // Inchide avans dupa finalizare reparatie si predare restul de bani si produs
        Route::any('/notificari/activeaza-dezactiveaza/{notificari}', 'NotificareController@update_activa_inactiva');
        Route::resource('notificari', 'NotificareController');

        Route::get('/acasa', 'AcasaController@index')->name('acasa');

        Route::get('/home', 'HomeController@index')->name('home');

        Route::resource('sms-trimise', 'SmsTrimisController');

        Route::resource('masini', MasinaController::class,  ['parameters' => ['masini' => 'masina']]);
        Route::resource('soferi', SoferController::class,  ['parameters' => ['soferi' => 'sofer']]);

        // Route::view('/testare_cod', 'testare_cod');

        // Route::get('/testare-plata-card', 'PlataOnlineController@testarePlataCard')->name('testare-plata-card');
        // Route::post('/confirmare-plata', 'PlataOnlineController@confirmarePlata')->name('confirmare-plata');
        // Route::get('/return-url', 'PlataOnlineController@returnUrl')->name('return-url');

    });
});



