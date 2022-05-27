<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerVoti;
use App\Http\Controllers\ControllerUtenti;
use App\Http\Controllers\ControllerOperatori;

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
Route::get('/', [ControllerVoti::class, 'index'])->name("vota");
Route::post('/', [ControllerVoti::class, 'vota']);


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [ControllerUtenti::class, 'index_login'])->name("login");
    Route::post('/login', [ControllerUtenti::class, 'store_login']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::post("/logout", [ControllerUtenti::class, "logout"])->name("logout");
});


Route::group(['middleware' => ['auth', 'soloAdmin']], function () {
    Route::get('/reset', [ControllerVoti::class, 'reset'])->name("reset");
    Route::get('/register', [ControllerUtenti::class, 'index_register'])->name("register");
    Route::post('/register', [ControllerUtenti::class, 'store_register']);
});

Route::group(['middleware' => ['auth', 'soloScrutatori']], function () {
    Route::get('/PannelloScrutatore', [ControllerOperatori::class, 'index_scrutatore'])->name("scrutatore");
    Route::post('/PannelloScrutatore', [ControllerOperatori::class, 'index_scrutatore']);
    Route::post('/toggleVotazioni', [ControllerOperatori::class, 'toggleVoti'])->name("toggleVotazioni");
});

Route::group(['middleware' => ['auth', 'soloAccoglienza']], function () {
    Route::get('/PannelloAccoglienza', [ControllerOperatori::class, 'index'])->name("accoglienza");
    Route::post('/PannelloAccoglienza', [ControllerOperatori::class, 'index']);
    Route::post('/generaCodici', [ControllerOperatori::class, 'generaCodici'])->name("codeGen");
});
