<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerAmministratore;
use App\Http\Controllers\ControllerSegretario;
use App\Http\Controllers\ControllerScrutatore;
use App\Http\Controllers\ControllerUtenti;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/', [ControllerUtenti::class, 'index'])->name("homepage");
Route::post('/vota/referendum', [ControllerUtenti::class, 'Referendum'])->name("vota_referendum");
Route::post('/vota/elezioni', [ControllerUtenti::class, 'Elezioni'])->name("vota_elezioni");


Route::get('/clear-cache-all', function () {
    Artisan::call('cache:clear');
    dd("Cache Clear All");
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [ControllerUtenti::class, 'login'])->name("login");
    Route::post('/login', [ControllerUtenti::class, 'store_login']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::post("/logout", [ControllerUtenti::class, "logout"])->name("logout");
});


Route::group(['middleware' => ['auth', 'soloAdmin']], function () {
    Route::get('/PannelloAdmin', [ControllerAmministratore::class,'index'])->name("admin");
    Route::post('/PannelloAdmin', [ControllerAmministratore::class, 'store']);
    Route::get('/PannelloAdmin/setupServer', [ControllerAmministratore::class, 'setupServer'])->name("setupServer");
    Route::post('/PannelloAdmin/ClearData', [ControllerAmministratore::class,'clearData'])->name("clearData");
    Route::post('/PannelloAdmin/Register', [ControllerAmministratore::class, 'store_register'])->name("register");
});

Route::group(['middleware' => ['auth', 'soloScrutatori']], function () {
    Route::get('/PannelloScrutatore', [ControllerScrutatore::class, 'index'])->name("scrutatore");
    Route::post('/PannelloScrutatore', [ControllerScrutatore::class, 'store']);
    Route::post('/PannelloScrutatore/toggleVotazioni', [ControllerScrutatore::class, 'toggleVoti'])->name("toggleVotazioni");
    Route::post('PannelloScrutatore/resetData', [ControllerScrutatore::class, 'resetData'])->name("resetData");
    Route::get('/PannelloScrutatore/ModalCandidati', [ControllerScrutatore::class, 'modalCandidati']);
    Route::post('/PannelloScrutatore/ModalCandidati', [ControllerScrutatore::class, 'modificaCandidati'])->name("ModificaCandidati");
    Route::get('/PannelloScrutatore/ModalOpzioni', [ControllerScrutatore::class, 'modalOpzioni']);
    Route::post('/PannelloScrutatore/ModalOpzioni', [ControllerScrutatore::class, 'modificaOpzioni'])->name("ModificaOpzioni");
});

Route::group(['middleware' => ['auth', 'soloSegretario']], function () {
    Route::get('/PannelloSegretario', [ControllerSegretario::class, 'index'])->name("segretario");
    Route::post('/PannelloSegretario', [ControllerSegretario::class, 'store']);
    Route::post('/PannelloSegretario/entrata', [ControllerSegretario::class, 'entrata'])->name("entrata");
    Route::post('/PannelloSegretario/uscita', [ControllerSegretario::class, 'uscita'])->name("uscita");
});
