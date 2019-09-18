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

    Route::get('agentii/rezervari', 'UserFirmaController@rezervari');
    Route::get('agentii/rezervari/export/{view_type}/{search_data_inceput}/{search_data_sfarsit}', 'UserFirmaController@pdfexport_rezervari_agentie');  // Generare PDF

    Route::view('/instructiuni-rezervari', 'instructiuni_rezervari');
        
    Route::post('users/loginas', 'UserController@loginAs')->name('loginas');;

    Route::group(['middleware' => 'dispecer'], function () {
        Route::resource('/clienti-neseriosi', 'ClientNeseriosController');

        //Ruta pentru cautarea completa pe o zi sau mai multe
        Route::any('/rezervari-raport-zi', 'RezervareRaportZiController@index');
        
        // Extras date cu Axios pentru rezervari-raport-zi
        Route::get('/orase_ore_zi_rezervari', 'RezervareRaportZiController@orase_ore_zi_rezervari');

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

        Route::resource('agentii', 'UserFirmaController');
        Route::get('agentii/{agentii}/rezervari', 'UserFirmaController@rezervari');
        Route::get('agentii/{agentii}/rezervari/export/{view_type}/{search_data_inceput}/{search_data_sfarsit}', 'UserFirmaController@pdfexport_rezervari_dispecer');  // Generare PDF

        Route::get('/acasa', 'AcasaController@index')->name('acasa');

        Route::get('/home', 'HomeController@index')->name('home');  

        Route::get('/testare-plata-card', 'RezervareController@testarePlataCard')->name('testare-plata-card');  
        Route::get('/testare-plata-card1', 'RezervareController@testarePlataCard1')->name('testare-plata-card1');  

        Route::get('/clear', function() {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('config:cache');
            Artisan::call('view:clear');
        return "Cleared!";
        });
    });
});



